<?php
require_once 'entities/UserEntity.php';
require_once 'entities/GameConfigEntity.php';
require_once 'entities/CourseEntity.php';
require_once 'services/UserService.php';
require_once 'services/CourseService.php';

class SeedService
{
    public function seedDatabase()
    {
        $this->cleanDatabase();

        $adminId = $this->createAdminUser();
        $this->createStudents();
        $this->createCourses($adminId);
    }

    private function cleanDatabase()
    {
        CourseService::deleteAll();
        UserService::deleteAll();
    }

    private function createAdminUser()
    {
        $user = new UserEntity([
            'first_name' => 'Root',
            'last_name' => 'Admin',
            'email' => 'admin@ug.edu.ec',
            'password' => password_hash('holamundo', PASSWORD_DEFAULT),
            'role' => 'admin',
        ]);

        $adminId = UserService::createUser($user);
        return $adminId;
    }

    private function createStudents()
    {
        $students = [
            [
                'first_name' => 'Juan',
                'last_name' => 'Perez',
                'email' => 'juan@ug.edu.ec',
                'password' => password_hash('holamundo', PASSWORD_DEFAULT),
                'role' => 'student',
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Gomez',
                'email' => 'maria@ug.edu.ec',
                'password' => password_hash('holamundo', PASSWORD_DEFAULT),
                'role' => 'student',
            ],
            [
                'first_name' => 'Pedro',
                'last_name' => 'Lopez',
                'email' => 'pedro@ug.edu.ec',
                'password' => password_hash('holamundo', PASSWORD_DEFAULT),
                'role' => 'student',
            ],
        ];

        foreach ($students as $student) {
            UserService::createUser(new UserEntity($student));
        }
    }

    private function createCourses($adminId)
    {
        $courses = [
            [
                'course_code' => 'SOF-S-MA-1-1',
                'course_name' => 'Ingeniería de Requerimientos',
                'items_per_attempt' => 5,
                'max_attempts' => 3,
            ],
        ];

        foreach ($courses as $course) {
            CourseService::create(
                new CourseEntity(
                    $course['course_name'],
                    $course['course_code'],
                    $course['items_per_attempt'],
                    $course['max_attempts'],
                ),
                new GameConfigEntity('es', 'Aplicación de gestión del tiempo.'),
                $adminId
            );
        }
    }
}
