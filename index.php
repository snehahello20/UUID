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
// echo "<pre>";
// print_r($student_responses);
// echo "</pre>";

$algebra = 0;
$algebra_data = [];
$geometry = 0;
$geometry_data = [];
$probability = 0;
$probability_data = [];
foreach($questions as $question)
{
  if($question['strand'] === 'Number and Algebra'){
    $algebra++;
    array_push($algebra_data,$question);
  }
  else if($question['strand'] === 'Measurement and Geometry'){
    $geometry++;
    array_push($geometry_data,$question);
  }
  else if($question['strand'] === 'Statistics and Probability'){
    $probability++;
    array_push($probability_data,$question);
  }
}

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
                            <form action="" class="justify-content-center" id="input-data">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label class="sr-only">Student</label>
                                            <select  class="form-control student" id="student">
                                                <option value="0" selected>Select Student</option>
                                                <?php
                                                foreach($students as $student){
                                                    echo '<option value="'.$student['id'].'">
                                                    '.$student['firstName']. ' ' .$student['lastName'].'
                                                    </option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label class="sr-only">Report Type</label>
                                            <select  class="form-control report" id="report">
                                                <option value="0" selected>Report Type</option>
                                                <option value="1">Dignostic Report</option>
                                                <option value="2">Progress Report</option>
                                                <option value="3">Feedback Report</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                       <button type="submit" class="btn btn-primary btn-sm ">Submit</button>
                                    </div>
                                </div>
                              
                               
                                <h6 class="text-center">Report</h6>
                                <div id="output" style="border : 1px solid grey; padding : 20px;border-radius : 10px;">
                                   
                                </div>
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
            $('.report').select2();
        });

        var algebra = parseInt("<?php echo $algebra; ?>");
        var algebra_data = <?php echo json_encode($algebra_data); ?>;
        var geometry = parseInt("<?php echo $geometry; ?>");
        var geometry_data = <?php echo json_encode($geometry_data); ?>;
        var probability = parseInt("<?php echo $probability; ?>");
        var probability_data = <?php echo json_encode($probability_data); ?>;
        var student_responses = <?php echo json_encode($student_responses); ?>;
        var questions = <?php echo json_encode($questions); ?>;
        var students = <?php echo json_encode($students); ?>;

        $(function(){
           $('#input-data').on('submit', function(e){
               e.preventDefault();
            $('#output').html('');
              var student = $('#student').val();
              var report = $('#report').val();

              if(student == 0){
                  alert('Please select one of the student from the list.');
                  return;
              }
              if(report == 0){
                  alert('Please select one of the report type.');
                  return;
              }
              var user_algebra = 0;
              var user_data = [];
              for (const element of student_responses) {
                  if(element.student.id === student){
                    user_data.push(element);
                  }
              }

              var user_info = {};
              for (const stud of students) {
                  if(stud.id === student){
                    user_info = stud
                  }
              }

              
              var collect_data = [];
              var user_algebra = [];
              var user_probability = [];
              var user_geometry = [];

              for(const user of user_data){
                var alg = 0;
                var geo = 0;
                var prob = 0;
                for (const qes of questions) {
                    if(qes['strand'] === 'Number and Algebra')
                    {
                        for(const res of user.responses){
                            if(res.questionId === qes['id'] && qes.config.key === res.response){
                                alg++;
                            }
                        }
                    }
                    else if(qes['strand'] === 'Statistics and Probability')
                    {
                        for(const res of user.responses){
                            if(res.questionId === qes['id'] && qes.config.key === res.response){
                                prob++;
                            }
                        }
                    }
                    else if(qes['strand'] === 'Measurement and Geometry')
                    {
                        for(const res of user.responses){
                            if(res.questionId === qes['id'] && qes.config.key === res.response){
                                geo++;
                            }
                        }
                    }
                }
                user_algebra.push(alg);
                user_probability.push(prob);
                user_geometry.push(geo);
              }

              var html = "";
              if(report == 1){
                 html += `
                       <h4 class="text-center">Diagnostic Report</h4>
                      `;
                  for(var i = 0; i < user_data.length ; i++){
                      html += `
                        <p>
                             ${user_info.firstName} ${user_info.lastName} completed Numerancy measurement on ${user_data[i].started}, he got ${user_data[i].results.rawScore} out of ${questions.length}. Details by strand given below.
                        </p>
                      `;
                      html += `
                       <h6>
                         Numeracy and Algebra : ${user_algebra[i]} out of ${algebra} correct
                       </h6>
                      `;

                      html += `
                       <h6>
                         Measurement and Geometry : ${user_geometry[i]} out of ${geometry} correct
                       </h6>
                      `;

                      html += `
                       <h6>
                         Statistics and Probability : ${user_probability[i]} out of ${probability} correct
                       </h6>
                      `;
                      html += '<hr>';

                      $('#output').html(html);
                  }
                  
              }
              
              console.log(user_data)
              if(report == 2){
                  html += `
                       <h4 class="text-center">Progress Report's</h4>
                      `;
                  html += `
                        <p>
                             ${user_info.firstName} ${user_info.lastName} has completed Numerancy assesment on ${user_data.length} times in total. Date and row score given below.
                        </p>
                      `;

                  var user_variation =[];

                  for(var z=0; z < user_data.length; z++)
                  {
                    html += `
                       <h6>
                         Date : ${user_data[z].started}, Raw Score ${user_geometry[z] + user_probability[z] + user_algebra[z]} : out of ${questions.length} 
                       </h6>
                      `;
                      html += '<hr>';
                    
                      user_variation.push(user_geometry[z] + user_probability[z] + user_algebra[z]);
                  }
                  
                  var variation = user_variation[user_variation.length - 2] < user_variation[user_variation.length - 1] ? 'more' : 'less';
                  var count = 0;
                  var correct = "";
                  if(variation == 'more'){
                     count = user_variation[user_variation.length - 1] - user_variation[user_variation.length - 2];
                  }
                  else{
                    count = user_variation[user_variation.length - 2] - user_variation[user_variation.length - 1];
                  }
                  html += `
                  ${user_info.firstName} ${user_info.lastName} got ${count} ${variation} correct in the recent assesment than the oldest
                  `;

                  $('#output').html(html);
               
              }
           })
        })
    </script>
</body>
</html>