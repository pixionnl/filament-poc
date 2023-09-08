<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseUserSeeder extends Seeder
{

    protected $courseIds = [];

    public function __construct()
    {
        $this->setCourseIds();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('course_user')->truncate();

        User::all()->each(function(User $user) {
            $user->courses()->attach($this->getRandomCourseIds());
        });
    }

    /**
     *
     * @return array
     */
    protected function getRandomCourseIds(): array
    {
        $courseIds = $this->courseIds;
        shuffle($courseIds);

        return array_slice($courseIds, 0, rand(1, 6));
    }

    /**
     *
     * @return void
     */
    protected function setCourseIds(): void
    {
        $this->courseIds = Course::get()->pluck('id')->toArray();
    }
}
