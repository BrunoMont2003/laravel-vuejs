<?php

namespace Tests\Feature;

use App\Models\Resume;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicationTest extends TestCase
{
    use RefreshDatabase;
    private $user;
    private $publication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $resume = $this->user->resumes()->create(Resume::factory()->make()->toArray());
        $theme = new Theme(['theme' => 'classy']);
        $theme->save();
        $this->publication = $this->user->publications()->create([
            'resume_id' => $resume->id,
            'theme_id' => $theme->id,
            'visibility' => 'private'
        ]);
    }

    public function testCannotSeePrivatePublicationIfNotLoggedIn()
    {
        $response = $this->get('publications/' . $this->publication->id);
        $response->assertStatus(302);
    }

    public function testCannotSeePrivatePublicationIfDoesntBelongToUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('publications/' . $this->publication->id);
        $response->assertForbidden();
    }

    public function testCanAccessPublicPublication()
    {
        $this->withoutExceptionHandling();
        $this->user->publications()->where('id', $this->publication->id)->first()->update([
            'visibility' => 'public',
        ]);
        $user = User::factory()->create();
        $response = $this->get('publications/' . $this->publication->id);
        $response->assertOk();
        $this->actingAs($user);
        $response = $this->get(route('publications.show', $this->publication->id));
        $response->assertOk();
    }
}