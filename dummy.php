<?php
$questions = file_get_contents('questions.json');
$student_responses = file_get_contents('student-responses.json');
$students = file_get_contents('students.json');
$assesments = file_get_contents('assesments.json');
  
// Decode the JSON file
$questions = json_decode($questions,true);
$student_responses = json_decode($student_responses,true);
$students = json_decode($students,true);
$assesments = json_decode($assesments,true);
// var_dump($student_responses);
?>

