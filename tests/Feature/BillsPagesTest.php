<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * The public bills list (status tabs, filters, open data) and the Bill
 * page's journey through Parliament.
 */
class BillsPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.remote_base_url' => 'https://legitrack.test']);
    }

    private function bill(array $overrides = []): array
    {
        return $overrides + [
            'slug' => 'the-health-services-bill', 'title' => 'the health services bill', 'subject' => 'Health', 'plain_summary' => 'Gives counties ninety days to set up health facility boards.',
            'excerpt' => 'Gives counties ninety days to set up health facility boards.', 'number' => 'National Assembly Bills No. 5 of 2026', 'house' => 'National Assembly of Kenya',
            'category' => 'ordinary', 'category_label' => 'Ordinary Bill', 'type' => 'Public Bill', 'sponsor' => 'Hon. Aisha Hassan', 'status' => 'before_parliament',
            'status_label' => 'Before Parliament', 'stage' => 'Committee Consideration and Public Participation', 'latest_outcome' => 'Call for Public Participation Issued',
            'gazette_published_at' => '2026-05-02', 'gazette_supplement_number' => '41', 'updated_at' => '2026-05-20', 'open_for_comment_until' => now()->addDays(9)->toDateString(),
        ];
    }

    private function fakeList(array $bills, array $counts = ['before_parliament' => 3, 'passed' => 1, 'became_law' => 2, 'did_not_proceed' => 0], int $open = 1): void
    {
        Http::fake([
            'legitrack.test/up' => Http::response('', 200),
            'legitrack.test/api/get-house-categories*' => Http::response(['data' => ['data' => [['id' => 1, 'name' => 'National Assembly of Kenya'], ['id' => 2, 'name' => 'Senate of Kenya']]]]),
            'legitrack.test/api/public/bills/export.csv*' => Http::response("\"Bill number\",Title\n\"National Assembly Bills No. 5 of 2026\",\"The Health Services Bill\"\n", 200, ['Content-Type' => 'text/csv']),
            'legitrack.test/api/public/bills*' => Http::response(['data' => ['bills' => $bills, 'meta' => ['total' => count($bills), 'page' => 1, 'last_page' => 1, 'per_page' => 12, 'status_counts' => $counts, 'open_for_comment' => $open]]]),
        ]);
    }

    public function test_the_bills_list_shows_status_tabs_cards_and_open_for_comment(): void
    {
        $this->fakeList([$this->bill(), $this->bill(['slug' => 'the-finance-bill', 'title' => 'the finance bill', 'status' => 'became_law', 'status_label' => 'Became law', 'open_for_comment_until' => null, 'category' => 'money', 'category_label' => 'Money Bill (Art. 114)'])]);

        $this->get('/bills')->assertOk()
            ->assertSee('Bills in the Parliament of Kenya')
            ->assertSeeInOrder(['All Bills', '6', 'Open for comment', '1', 'Before Parliament', '3', 'Passed by Parliament', '1', 'Became law', '2'])
            ->assertSee('The Health Services Bill')->assertSee('National Assembly Bills No. 5 of 2026')
            ->assertSee('Open for comment · 9 days left', false)
            ->assertSee('Gives counties ninety days to set up health facility boards.')
            ->assertSee('Money Bill (Art. 114)')
            ->assertSee(route('get-bill-details', 'the-finance-bill'))
            ->assertSee(route('bills.export'));
    }

    public function test_filters_are_passed_to_legitrack_and_old_links_still_work(): void
    {
        $this->fakeList([]);

        $this->get('/bills?q=roads&status=became_law&house=2&open=1&sort=title')->assertOk()->assertSee('No Bills match these filters');
        Http::assertSent(fn (Request $r) => str_contains($r->url(), '/api/public/bills?') && str_contains($r->url(), 'q=roads')
            && str_contains($r->url(), 'status=became_law') && str_contains($r->url(), 'house=2') && str_contains($r->url(), 'open=1') && str_contains($r->url(), 'sort=title'));

        // The home page search and older links used "search" and "house_category_id".
        $this->get('/bills?search=health&house_category_id=1&page=2')->assertOk();
        Http::assertSent(fn (Request $r) => str_contains($r->url(), 'q=health') && str_contains($r->url(), 'house=1') && str_contains($r->url(), 'page=2'));

        $this->get('/bills?status=everything')->assertSessionHasErrors('status');
    }

    public function test_an_empty_parliament_says_no_bills_are_published_yet(): void
    {
        $this->fakeList([], ['before_parliament' => 0, 'passed' => 0, 'became_law' => 0, 'did_not_proceed' => 0], 0);

        $this->get('/bills')->assertOk()->assertSee('No Bills have been published yet');
    }

    public function test_open_data_csv_is_downloadable(): void
    {
        $this->fakeList([]);

        $response = $this->get('/bills/export.csv?status=became_law')->assertOk();
        $this->assertStringContainsString('attachment; filename="kenya-bills-', $response->headers->get('Content-Disposition'));
        $this->assertStringContainsString('The Health Services Bill', $response->getContent());
        Http::assertSent(fn (Request $r) => str_contains($r->url(), 'export.csv') && str_contains($r->url(), 'status=became_law'));
    }

    public function test_unpublished_bills_are_not_public(): void
    {
        Http::fake([
            'legitrack.test/up' => Http::response('', 200),
            'legitrack.test/api/public/bills/*' => Http::response(['message' => 'Bill not found'], 404),
            'legitrack.test/api/get-bills/*' => Http::response(['data' => ['data' => ['id' => 7, 'attributes' => ['title' => 'A draft']]]]),
        ]);

        $this->get('/a-draft-bill')->assertNotFound();
    }

    public function test_the_journey_and_at_a_glance_panels(): void
    {
        $tracker = [
            ['key' => 'publication', 'label' => 'Published in the Kenya Gazette', 'house' => 'Kenya Gazette', 'state' => 'done', 'outcome' => 'Published in the Kenya Gazette', 'date' => '2026-05-02'],
            ['key' => 'first_reading', 'label' => 'First Reading', 'house' => 'National Assembly', 'state' => 'done', 'outcome' => 'First Reading Completed', 'date' => '2026-05-12'],
            ['key' => 'committee', 'label' => 'Committee and public participation', 'house' => 'National Assembly', 'state' => 'current', 'outcome' => 'Call for Public Participation Issued', 'date' => '2026-05-15'],
            ['key' => 'second_reading', 'label' => 'Second Reading', 'house' => 'National Assembly', 'state' => 'upcoming', 'outcome' => null, 'date' => null],
        ];
        $html = view('partials.bill_tracker', ['tracker' => $tracker])->render();
        $this->assertStringContainsString('tracker-done', $html);
        $this->assertStringContainsString('Committee and public participation <span class="tracker-state">In progress</span>', $html);
        $this->assertStringContainsString('National Assembly · Call for Public Participation Issued · 15 May 2026', $html);

        $glance = view('partials.bill_at_a_glance', ['public' => $this->bill() + [
            'deadlines' => [['label' => 'President to assent or refer the Bill back', 'legal_basis' => 'Constitution Art. 115(1)', 'kind' => 'due', 'due_on' => '2026-06-20', 'status' => 'open']],
            'versions' => [['number' => 1, 'date' => '2026-05-02', 'pdf_url' => 'https://legitrack.test/get-bill-version-pdf/3']],
        ]])->render();
        $this->assertStringContainsString('What this Bill does', $glance);
        $this->assertStringContainsString('Supplement No. 41, 2 May 2026', $glance);
        $this->assertStringContainsString('President to assent or refer the Bill back: by 20 Jun 2026', $glance);
        $this->assertStringContainsString('https://legitrack.test/get-bill-version-pdf/3', $glance);
    }

    public function test_signed_in_visitors_follow_and_unfollow_a_bill(): void
    {
        Http::fake([
            'legitrack.test/up' => Http::response('', 200),
            'legitrack.test/api/public/bills/the-health-services-bill/follow' => Http::response(['data' => ['following' => true, 'followers' => 1]]),
        ]);
        $user = \App\Models\User::factory()->create();

        $this->post(route('bill.follow', 'the-health-services-bill'))->assertRedirect(route('login'));

        $this->actingAs($user)->withSession(['api_token' => 'token-123'])->from('/the-health-services-bill')
            ->post(route('bill.follow', 'the-health-services-bill'))->assertRedirect('/the-health-services-bill')->assertSessionHas('success');
        Http::assertSent(fn (Request $r) => $r->method() === 'POST' && str_ends_with($r->url(), '/api/public/bills/the-health-services-bill/follow') && $r->hasHeader('Authorization', 'Bearer token-123'));

        $this->from('/the-health-services-bill')->delete(route('bill.unfollow', 'the-health-services-bill'))->assertSessionHas('success');
        Http::assertSent(fn (Request $r) => $r->method() === 'DELETE' && str_ends_with($r->url(), '/follow'));
    }

    public function test_the_follow_button_and_one_click_unsubscribe(): void
    {
        $html = view('partials.follow_bill', ['slug' => 'the-health-services-bill', 'follow' => ['following' => false, 'followers' => 12]])->render();
        $this->assertStringContainsString('Sign in to follow', $html);
        $this->assertStringContainsString('12 people follow this Bill.', $html);

        Http::fake([
            'legitrack.test/up' => Http::response('', 200),
            'legitrack.test/api/public/bills/unfollow/good-token' => Http::response(['data' => ['unfollowed' => true, 'bill_title' => 'the health services bill']]),
            'legitrack.test/api/public/bills/unfollow/*' => Http::response(['data' => ['unfollowed' => false]], 404),
        ]);
        $this->get(route('unfollow', 'good-token'))->assertOk()->assertSee('You have stopped following')->assertSee('The Health Services Bill');
        $this->get(route('unfollow', 'used-token'))->assertOk()->assertSee('This link has already been used');
    }
}
