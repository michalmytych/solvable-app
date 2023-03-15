<?php

namespace App\Repositories;

use App\Models\Course;
use App\DTOs\CourseDTO;
use Spatie\LaravelData\Contracts\DataCollectable;
use App\Contracts\Repositories\CourseRepositoryInterface;

class CourseRepository implements CourseRepositoryInterface
{
    public function allByUserId(string $id): DataCollectable
    {
        $courses = Course::where('user_id', $id)->get();

        return CourseDTO::collection($courses);
    }

    public function store(array $data): CourseDTO
    {
        $course = Course::create($data);

        return CourseDTO::from($course);
    }

    public function update(string $id, array $data): CourseDTO
    {
        $course = Course::findOrFail($id);

        return CourseDTO::from(
            tap($course)->update($data)
        );
    }

    public function delete(string $id): bool
    {
        return (bool) Course::destroy($id);
    }
}
