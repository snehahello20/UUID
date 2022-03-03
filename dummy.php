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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dependency</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    
    <section id="cover" class="min-vh-100">
        <div id="cover-caption">
            <div class="container">
                <div class="row text-dark">
                    <div class="col-xl-7 col-lg-6 col-md-8 col-sm-10 mx-auto form p-4">
                        <h1 class="display-5 py-2 text-truncate">Student Assesment</h1>
                        <div class="px-2">
                            <form action="" class="justify-content-center">
                                <div class="form-group">
                                    <label class="sr-only">Student</label>
                                    <select  class="form-control student" >
                                        <option value="" selected>Select Student</option>
                                        <?php
                                          foreach($students as $student){
                                              echo '<option value="'.$student['id'].'">
                                              '.$student['firstName']. ' ' .$student['lastName'].'
                                              </option>';
                                          }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="sr-only">Student</label>
                                    <select  class="form-control student" >
                                        <option value="" selected>Select Student</option>
                                        <?php
                                          foreach($students as $student){
                                              echo '<option value="'.$student['id'].'">
                                              '.$student['firstName']. ' ' .$student['lastName'].'
                                              </option>';
                                          }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="sr-only">Assesment</label>
                                    <select  class="form-control assesment">
                                        <option value="" selected>Select Assesment</option>
                                        <?php
                                          foreach($assesments as $assesment){
                                              echo '<option value="'.$assesment['id'].'">
                                              '.$assesment['name'].
                                              '</option>';
                                          }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">Questions</label>
                                    <?php
                                      foreach($questions as $question){
                                         
                                          echo '<h6>'.$question['strand'].'</h6>';
                                          echo '<h6>'.$question['stem'].'</h6>';
                                          echo '<h6>Question Type : '.$question['type'].'</h6>';
                                          foreach($question['config']['options'] as $option){
                                     
                                              echo '<input type="radio" id="'.$option['id'].'" name="'.$question['id'].'"> '.$option['label']. '.' .$option['value'].'<br>'; 
                                          }

                                          echo "<br><br>";
                                      }
                                    ?>
                                </div>
                               
                                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.student').select2();
            $('.assesment').select2();
        });
    </script>
</body>
</html>