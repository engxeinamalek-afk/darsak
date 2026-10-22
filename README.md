# Darsak
A Laravel API project for an educational platform with a dual system for students and instructors.

## User Roles & Permissions

### Students
Students can enroll in courses and access all related lessons and tasks within their enrolled courses. They can also interact by adding comments to these courses, lessons, and tasks.

###  Instructors
Instructors can create courses and add tags to them and their related elements. They can add lessons and tasks exclusively to their own courses, with the ability to upload images for tasks and lessons. Additionally, they can upload a personal profile picture.

##  Polymorphic Relationships

###  Image System
The application utilizes a single `images` table to handle all image attachments across different models using a One-to-One Polymorphic Relationship (`morphOne`).

* **Image Ownership:** Each instructor, course, and lesson can have exactly one image, and each image record belongs to only one parent entity.
* **Unified Media Upload Endpoint:** A single, polymorphic endpoint is used to handle image uploads for both lessons and tasks. It leverages **Dynamic Route Model Binding** to automatically resolve the target resource instance (whether a lesson or a task) from the URL parameter before it reaches the Form Request validation.
* **Profile Image Endpoint:** A separate, dedicated endpoint is configured specifically for instructors to upload and update their personal profile pictures.

### Comment System
The platform features a One-to-Many Polymorphic Relationship (`morphMany`) using a single `comments` table to manage interactions across multiple models.

* **Comment Ownership:** A student can post comments on courses, lessons, and tasks. Each comment belongs to a single target entity, while any course, lesson, or task can host multiple comments.
* **Unified Comment Endpoint:** A single, polymorphic endpoint handles comment creation across the platform. Just like the image system, it utilizes **Dynamic Route Model Binding** to automatically resolve the specific entity (course, lesson, or task) from the URL parameter efore it reaches the Form Request validation.

### Tagging System
The platform implements a Many-to-Many Polymorphic Relationship (`morphToMany`) using a unified tagging structure to categorize content dynamically.

* **Tag Ownership:** Instructors can attach tags to courses, lessons, and tasks. A single tag can be linked to multiple entities across different models, and any entity can have multiple tags simultaneously.
* **Unified Tagging Endpoint:** A single, polymorphic endpoint is utilized to manage and attach tags across the platform. It leverages **Dynamic Route Model Binding** to automatically identify the target resource (course, lesson, or task) directly from the URL parameter before it reaches the Form Request validation.

## Authorization & Policies

The application enforces strict security and data ownership using **Policies** mapped across `Course`, `Lesson`, and `Task` models. Each policy implements two primary authorization methods:

* **`manage` Method:** Restricts administrative privileges strictly to the course creator (Instructor). It verifies that an instructor can only modify, update, or add content to their own courses, ensuring they cannot touch lessons or tasks belonging to another instructor's course.
* **`access` Method:** Controls student data visibility based on enrollment. It ensures a student can only view or comment a course, or access its nested lessons and tasks, if they have an enrollment in that specific course.


## Query Performance Analytics

### Get Tag Resources
The endpoint `GET /api/tags/{tag}/resources` executes a total of 4 database queries:

* **Implicit Query:** Occurs automatically before entering the controller method resolve the `Tag` instance from the URL.
* **First Query:**  Batch-fetch the related `courses` while bypassing global scopes and selecting specific columns.
* **Second Query:** Batch-fetch specific columns (`id, name, url`) for the related `lessons`.
* **Third Query:** Batch-fetch specific columns (`id, name, body`) for the related `tasks`.


### Get Instructor Courses
The endpoint `GET /api/courses` executes a total of 4 database queries:

* **First Query:** To count the total number of courses created by the user to calculate pagination.
* **Second Query:** Batch-fetch specific columns (`courses.id, name, status, instructor_id`) for the instructor's courses for the current page (`LIMIT 10`), while bypassing the `PublishedCoursesScope`.
* **Third Query:** Batch-fetch specific columns (`id, course_id, name, url`) for the `lessons` associated with the fetched courses.
* **Fourth Query:** Batch-fetch specific columns (`id, lesson_id, name, body`) for the nested `tasks` linked to those lessons.

### Get Course Lessons
The endpoint `GET /api/courses/{instructor_course}/lessons` executes a total of 4 database queries:

* **Implicit Query:** Occurs automatically before entering the controller method to resolve the `Course` instance from the URL.
* **First Query:** To count the total number of lessons linked to this specific course to calculate pagination.
* **Second Query:** Batch-fetch specific columns (`id, course_id, name, url`) for the lessons associated with this course for the current page (`LIMIT 10`).
* **Third Query:** Batch-fetch specific columns (`id, lesson_id, name, body`) for the `tasks` linked to the fetched lessons.


### Get Recent Comments
The endpoint `GET /api/commentables` executes a minimum of 3 database queries. It utilizes polymorphic eager loading, which dynamically scales based on the types of records returned:

* **First Query:** To fetch the latest comments up to the defined request limit.
* **Second Query:** Batch-fetch specific columns (`id, name`) for the `students` who posted the retrieved comments.
* **Third Query (Dynamic):** Batch-fetch the specific columns (`id, name`) for the morphed entities (e.g., `courses`, `lessons`, or `tasks`) linked to the comments, executing exactly one single batch query per unique entity type found in the results.


### Get Student Course Lessons
The endpoint `GET /api/courses/{course}/lessons` executes a total of 4 database queries:

* **Implicit Query:** Occurs automatically before entering the controller method to resolve the `Course` instance from the URL.
* **First Query:** To count the total number of lessons linked to this specific course to generate the pagination metadata.
* **Second Query:** Batch-fetch specific columns (`id, course_id, name, url`) for the lessons associated with this course for the current page (`LIMIT 10`).
* **Third Query:** Batch-fetch specific columns (`id, lesson_id, name, body`) for the `task` linked to the retrieved lessons.


### Get Student Enrolled Courses
The endpoint `GET /api/courses` executes a total of 4 database queries:

* **First Query:** To count the total number of courses the authenticated student is enrolled in to calculate pagination.
* **Second Query:** Batch-fetch specific columns (`courses.id, name, status, instructor_id`) for the student's enrolled courses for the current page (`LIMIT 10`).
* **Third Query:** Batch-fetch specific columns (`id, course_id, name, url`) for the `lessons` associated with those fetched courses.
* **Fourth Query:** Batch-fetch specific columns (`id, lesson_id, name, body`) for the nested `tasks` linked to those lessons.









