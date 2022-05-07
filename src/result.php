   <?php
    require('./dbconnect.php');
    require('searchfun.php');
    $userData = getUserData($_GET);

    // $sql = 'SELECT * FROM company_posting_information';
    // $stmt = $db->query($sql);
    // $stmt->execute();
    // $companies = $stmt->fetchAll();

    ?>

   <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
     <link rel="stylesheet" href="style.css">
   </head>
   <div class="col-xs-6 col-xs-offset-3">
     <?php
      ?>
     <?php if (isset($userData) && count($userData)) : ?>

       <p class="alert alert-success"><?php echo count($userData) ?>件見つかりました。</p>

       <table class="table">
         <div>名前</div>
         <div>
           <?php foreach ($userData as $row) : ?>
             <div class='outline'>
               <a href="./detail.php?company_id='<?= $row['company_id']; ?>'">
                 <div>
                   <?php echo htmlspecialchars($row['industries']); ?>
                 </div>
                 <div>
                   <?php echo htmlspecialchars($row['name']); ?>
                 </div>
               </a>
             </div>
           <?php endforeach; ?>
         </div>
       </table>
     <?php else : ?>
       <p class="alert alert-danger">検索対象は見つかりませんでした。</p>
     <?php endif; ?>
   </div>