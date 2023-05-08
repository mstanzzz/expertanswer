<?php
$profile_id = 1;
$msg = (isset($_GET['msg'])) ? $_GET['msg'] : '';
$question_id = (isset($_GET['question_id']))? $_GET['question_id'] : 0; 
if(!isset($_SESSION['question_id'])) $_SESSION['question_id'] = $question_id;
?>

<!doctype html>
<html lang="en">
    <head>
        <link rel="icon" 
            type="image/png" 
            href="<?php echo "../favicon.png"; ?>" >

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Expert Answer</title>

        <!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="./assets/css/base.css">

        <script>
        function validate(theform){
                    
            return true;
        }

        </script>

    </head>

    <body style="background-color: #FFF1E5;">
        <?php
			require_once('includes/user-admin-nav.php');
		?>

        <main class="container my-3 p-0">

            <div class="d-flex justify-content-end">
                <a class="btn btn-info" href="questions-all.php"><i class="icon-arrow-left"></i> Back</a>
            </div>

			<div class="card shadow-sm mt-3">
				<div class="card-header">View Open Question</div>
				<div class="card-body">
                    <div class="row form-group">
                        <div class="col-12 col-md-2">Visitor Name</div>
                        <div class="col-12 col-md-10"><?php echo stripslashes($visitor_name); ?></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-12 col-md-2">Visitor Email</div>
                        <div class="col-12 col-md-10"><?php echo $visitor_email; ?></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-12 col-md-2">Visitor Zip</div>
                        <div class="col-12 col-md-10"><?php echo $visitor_zip; ?></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-12 col-md-2">Privacy</div>
                        <div class="col-12 col-md-10"></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-12 col-md-2">Date Submitted</div>
                        <div class="col-12 col-md-10"></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-12 col-md-2">Status</div>
                        <div class="col-12 col-md-10"></div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <h2>Question</h2>
                        </div> 

                        <div class="row">
                            The question goes here
                        </div>
                    </div>

                    <hr />
                    
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-info" href="answer-open-question.php?question_id=<?php echo $_SESSION['question_id']; ?>"><i class="icon-plus"></i> Add Answer</a>
                    </div>

                    <div class="container">
                        <div class="row">
                            <h2>Answers</h2>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form  name="a_form" action="view-open-question.php" method="post" enctype="multipart/form-data">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr class="table-secondary">
                                                <th width="15%">Answered By</th>
                                                <th width="8%">Active</th>
                                                <th width="8%">Edit</th>
                                                <th width="8%">Delete</th>    
                                                <th>Answer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    </body>
</html>
