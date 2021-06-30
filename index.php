<?php
    //
    $insert = false;
    $update = false;
    $delete = false;
  //connecting to database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "notes2";
  //create na connection
  $conn = mysqli_connect($servername,$username,$password,$database);
  //Die if connection was not successful
  if (!$conn) {
      die("sorry we failed to connect: " . mysqli_connect_error());
  }

  if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
    $result = mysqli_query($conn,$sql);
  }
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['snoEdit'])){
      //update the record
      $sno = $_POST["snoEdit"];
      $title = $_POST["titleEdit"];
      $description = $_POST["descriptionEdit"];
      $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";
      $result = mysqli_query($conn,$sql);
      if ($result) {
        //echo "The record has been inserted successfully";
        $update = true;
      }
      else {
        echo "The was not inserted successfully because of this error --->" 
        .mysqli_error($conn);
      }
    }
    else{
    $title = $_POST["title"];
      $description = $_POST["description"];
      $sql = "INSERT INTO `notes` ( `title`, `description`) VALUES ( '$title', '$description')";
      $result = mysqli_query($conn,$sql);
      if ($result) {
        //echo "The record has been inserted successfully";
        $insert = true;
      }
      else {
        echo "The was not inserted successfully because of this error --->" 
        .mysqli_error($conn);
      }
    }
  }

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  
  <title>iNotes Notes taking makes easy!</title>
 
</head>

<body>

<!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editmodal">
editmodal
</button> -->

<!--Edit Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editmodalLabel">Update Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="/todo_app/index.php" method="POST">
      <input type="hidden" name="snoEdit" id="snoEdit">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="titleEdit" name="titleEdit">
      </div>

      <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" id="descriptionEdit" name="descriptionEdit"
          style="height: 100px"></textarea>
        <label for="desc">Add Description</label>
      </div>
      <button type="submit" class="btn btn-primary my-4">Update Note</button>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        

      </div>
    </div>
  </div>
</div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">iNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>


        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  
  <?php
      if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been inserted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
    ?>
     <?php
      if ($delete) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
    ?>
     <?php
      if ($update) {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been Updated successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
    ?>
  <div class="container my-4">
    <h2>Add a Note</h2>
    <form action="/todo_app/index.php" method="POST">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>

      <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" id="description" name="description"
          style="height: 100px"></textarea>
        <label for="desc">Add Description</label>
      </div>
      <button type="submit" class="btn btn-primary my-4">Add Note</button>
    </form>
  </div>
  <div class="container my-4">

    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S. No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
            $sql = "SELECT * FROM `notes`";
            $result = mysqli_query($conn,$sql);
            $sno = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              $sno = $sno +1;
              echo "<tr>
              <th scope='row'>". $sno ."</th>
              <td>". $row['title'] ."</td>
              <td>". $row['description'] ."</td>
              <td> <button class='edit btn btn-sm btn-primary' id=". $row['sno'] .">Edit</button> <button class='delete btn btn-sm btn-primary' id=d". $row['sno'] .">Delete</button> </td>
            </tr>";
            }
              
              
    ?>


      </tbody>
    </table>
  </div>
  <hr>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
    crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
    <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
  
   <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element)=>{
      element.addEventListener("click",(e)=>{
        console.log("edit");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        $('#editmodal').modal('toggle');
        
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element)=>{
      element.addEventListener("click",(e)=>{
        console.log("delete");
        sno = e.target.id.substr(1,);

        if(confirm("Are You sure You want to delete this note!")){
          console.log("yes")
          window.location = `index.php?delete=${sno}`;
        }
        else{
          console.log("no");
        }
      })
    })
  </script>
</body>

</html>
