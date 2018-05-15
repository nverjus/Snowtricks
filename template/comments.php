<?php
$comments =  [];
for ($i = 0; $i <10 ; $i++) {
    $comments[] = array(
      'id' => $i,
      'publicationDate' => '08/05/08',
      'content' => 'Comment add with AJAX',
      'user' => array(
        'name' => 'Ajax User',
        'image' => 'img/user.jpg',
      ),
  );
}

header('Content-Type: application/json');
echo json_encode($comments);
