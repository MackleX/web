<?php 

require_once("../config/config.php");
?>

<?php
 if(isset($_REQUEST['product_id'])){
    $productid = $_REQUEST['product_id'];
    $active = $_REQUEST['product_is_active'];



    $statement = $pdo->prepare("update product set product_is_active=? where product_id= ?"); 
    $statement->execute(array($active,$productid));

    ob_clean();
    echo "SUCCESS";
    exit;
}  




$total=0;
if(isset($_POST['form1'])) {
    
    if(isset($_POST['client_email'])){
    
        $client_email = strip_tags($_POST['client_email']);
        $statement = $pdo->prepare("SELECT product_name,product_id,product_is_active,product_featured_photo,product_qty,product_price from product inner join  client on client.client_id=product.product_seller_id where client.client_email=?");
        $statement->execute(array($client_email));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
       
       
       
        
        
            
        }
    }elseif(isset($_POST['form2'])){
        if(isset($_POST['product-id'])){
    
            $product_id = strip_tags($_POST['product-id']);
            $statement = $pdo->prepare("SELECT product_name,product_id,product_is_active,product_featured_photo,product_qty,product_price from product where product_id=?");
            $statement->execute(array($product_id));
            $total = $statement->rowCount();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            
                                                               
                                                              
    }
}



?>


<body class="">
    <div class="wrapper ">
        <div class="sidebar " data-color="purple" data-background-color="white">

            <?php require_once('sidebar.php'); ?>

        </div>


        <div class="main-panel">


            <div class="content">
                <?php require_once('nav-bar.php'); ?>  


                <div class="container-fluid new">
                            <div class="row my_content">
                                <div class="col-md-12">
                                    <div class="card card-plain">

                                        <div class="card-header card-header-primary">
                     <form action="" method="post">            
                        <div class="row">
                               
                                <div class="col-md-3">
                                    <label for="">Email*</label>
                                    <input type="email" class="form-control" name="client_email" >
                                  
                                </div>
                                <div class="col-md-3" >
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-primary" value="search" name="form1" style=" width:100%; height:100%">
                               
                                </div>
                                <div class="col-md-3">
                                    <label for="">product-id *</label>
                                    <input type="text" class="form-control" name="product-id">
                                </div>
                                <div class="col-md-3" >
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-primary" value="search" name="form2" style=" width:100%; height:100%">

                                </div>
                                
                        </div>
                    </from>                        
                    
                     </div>

                                        <div class="card-body">
                                         <div class="table-responsive ">
                                          <table class="table table-hover my_content_table">
                                                    <thead class="">
                                                        <th>
                                                            Serial
                                                        </th>
                                                        <th>
                                                            Product name
                                                        </th>
                                                        <th>
                                                          photo
                                                        </th>
                                                        <th>
                                                        price
                                                        </th>
                                                        <th>
                                                        quantity
                                                        </th>
                                                        
                                                    </thead>
                                                    <tbody class="my_contentx">

                                                        <?php if($total) {
                                                            foreach ($result as $index => $row) { ?>
                                                            
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $index + 1; ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $row['product_name']; ?>
                                                                    </td>
                                                                    <td>
                                                                   <?php echo  $row['product_featured_photo'];?>
                                                                    </td>
                                                                    <td>
                                                                    <?php echo $row['product_price']." dh";?>
                                                                    </td>
                                                                   
                                                                    <td>
                                                                    <?php echo $row['product_qty'];?>
                                                                    </td>
                                                                    <td>
                              <?php      


                            if ($row['product_is_active'] == 0) {
                             ?>

                             <a class='statusButton btn btn-success _<?php echo $row['product_id'] ?>' onclick="stateChange(true,this)">Enable</a>

                            <?php

                            } else {

                            ?>

                                <a class='statusButton btn btn-danger _<?php echo $row['product_id'] ?>' onclick="stateChange(false,this)">Disable</a>

                        <?php

                            }




                            echo "</td>";
                        

                        ?>
                                                                   
                                                               
                                                                 
                                                                 
                                                                 
                                                            <?php }
                                                        } else {  ?>
                                                        
                                                            <tr class="warning">
                                                                <p class="text-warning"> NO ELEMENT IS SELECTED</p>
                                                               

                                                            </tr>
                                                        <?php } ?>

                                                    </tbody>
                                                </table>

                                                

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                </div>



            </div>




        </div>


    </div>

    


    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- Material Kit CSS -->
    <link href="../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />


    <script>
        function stateChange(Enable, elem) {
            product_id = elem.classList[3].substr(1);

            if (Enable) {
                sendObject = {
                    product_id: product_id,
                    product_is_active: 1
                }
            } else {
                sendObject = {
                    product_id: product_id,
                    product_is_active: 0
                }
            }


            $.ajax({
                type: 'POST',
                url: 'product.php',
                dataType: 'html',
                data: sendObject,
                success: function(data) {
                    debugger
                    if(data == "SUCCESS"){ 
                        if(Enable){
                        elem.innerHTML = "Disable"
                        elem.setAttribute('onclick','stateChange(false,this)')
                        elem.classList.remove("btn-success");
                        elem.classList.add("btn-danger");

                        }else{
                        elem.innerHTML = "Enable"
           

                        elem.classList.remove("btn-danger");
                        elem.classList.add("btn-success");
                        elem.setAttribute('onclick','stateChange(true,this)')
                        }
                    }else{
                        alert("error in php");
                    }
                    
                },
                error: function(data) {
                    alert("error on request")
                    debugger;

                }
            })


        }
    </script>
    