<?php

use App\Models\Course;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('does not find unreleased course', function () {
    $course = Course::factory()->create();

    get(route('pages.course-details', $course))
        ->assertNotFound();
});

it('shows course details', function () {
    // Arrange
    $course = Course::factory()->released()->create();

    // Act & Assert
    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText([
            $course->title,
            $course->description,
            $course->tagline,
            ...$course->learnings,
        ])
        ->assertSee(asset("images/{$course->image_name}"));
});

it('shows course video count', function () {

    $course = Course::factory()
        ->released()
        ->has(Video::factory(3))
        ->create();

    get(route('pages.course-details', $course))
        ->assertOk()
        ->assertSeeText('3 videos');
});