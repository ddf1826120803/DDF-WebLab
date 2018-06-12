<?php
//Fill this place

//****** Hint ******
//connect database and fetch data here
  $conn = new mysqli("localhost","root","ddf681126","travel");
  if($conn->connect_error){
    die("连接失败");
  }
  // 获得大洲
    $sql="SELECT * FROM continents";
    $result=$conn->query($sql);
  
  // 获得国家
    $sql2="SELECT * FROM countries";
    $result2=$conn->query($sql2);
 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chapter 14</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    
    

    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    

</head>

<body>
    <?php include 'header.inc.php'; ?>
    


    <!-- Page Content -->
    <main class="container">
        <div class="panel panel-default">
          <div class="panel-heading">Filters</div>
          <div class="panel-body">
            <form action="Lab10.php" method="get" class="form-horizontal">
              <div class="form-inline">
              <select name="continent" class="form-control">
                <option value="0">Select Continent</option>
                <?php
                //display the list of continents
                while($row = $result->fetch_assoc()) {
                  echo '<option value=' . $row['ContinentCode'] . '>' . $row['ContinentName'] . '</option>';
                }

                ?>
              </select>     
              
              <select name="country" class="form-control">
                <option value="0">Select Country</option>
                <?php
                /* display list of countries */ 
                  while($row2 = $result2->fetch_assoc()) {
                  echo '<option value=' . $row2['ISO'] . '>' . $row2['CountryName'] . '</option>';
                }
                ?>
              </select>    
              <input type="text"  placeholder="Search title" class="form-control" name=title>
              <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </form>

          </div>
        </div>     
                                    

		<ul class="caption-style-2">
            <?php 
            /* use while loop to display images that meet requirements ... sample below ... replace ???? with field data*/
              $continentSelect=isset($_GET['continent']) ? $_GET['continent']: "0" ;
              $countrySelect=isset($_GET['country']) ? $_GET['country'] : "0";
              if($continentSelect==="0"&&$countrySelect==="0"){
                     $sql3="SELECT * FROM imagedetails";filter($sql3);
              }
              else if($continentSelect!=="0"&&$countrySelect==="0"){
                     $sql3='SELECT * FROM imagedetails WHERE ContinentCode="'.$continentSelect.'"';filter($sql3);
              }
               else if($continentSelect==="0"&&$countrySelect!=="0"){
                   $sql3="SELECT * FROM imagedetails WHERE CountryCodeISO='".$countrySelect."'";filter($sql3);
              }
              else{
                   $sql3="SELECT * FROM imagedetails WHERE CountryCodeISO='".$countrySelect."' AND ContinentCode='".$continentSelect."'";filter($sql3);
              }
              function filter($sql3){
                global $conn;
                $result3=$conn->query($sql3);
                 while($row2 = $result3->fetch_assoc()) {
                  echo  '<li>
              <a href="detail.php?id='.$row2['ImageID'].'" class="img-responsive">
                <img src="images/square-medium/'.$row2['Path'].'" alt="'.$row2['Title'].'">
                <div class="caption">
                  <div class="blur"></div>
                  <div class="caption-text">
                    <p>????</p>
                  </div>
                </div>
              </a>
            </li>';
              }
            }
            // 关闭数据库
            $conn->close();
            ?>
       </ul>       

      
    </main>
    
    <footer>
        <div class="container-fluid">
                    <div class="row final">
                <p>Copyright &copy; 2017 Creative Commons ShareAlike</p>
                <p><a href="#">Home</a> / <a href="#">About</a> / <a href="#">Contact</a> / <a href="#">Browse</a></p>
            </div>            
        </div>
        

    </footer>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>