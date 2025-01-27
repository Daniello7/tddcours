<?php

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('gives back successful response for home page', function () {
    get(route('pages.home'))
        ->assertOk();
});

it('gives back successful response for course details page', function () {
    $course = Course::factory()->released()->create();

    get(route('pages.course-details', $course))
        ->assertOk();
});
