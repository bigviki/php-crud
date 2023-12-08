<!-- Sources=
    Connection: https://www.tutorialspoint.com/mongodb/mongodb_php.htm
    CRUD: https://www.youtube.com/watch?v=ywwuteLwcag
    Aggregation: https://www.mongodb.com/docs/manual/reference/operator/aggregation/lookup/#mongodb-pipeline-pipe.-lookup
    Copy home address to shipping: https://www.mongodb.com/community/forums/t/copy-documents-from-one-collection-to-another/183951
-->

<?php
    require 'vendor/autoload.php';

    $client = new MongoDB\Client("mongodb+srv://user:pass123@CS230.yjoxolp.mongodb.net/test");
    echo "Connection to database was successful";
    $db = $client->CS230;

    $user = $db->user;
    $home_address = $db->home_address;
    $shipping_address = $db->shipping_address;
    $item_details = $$db->item_details;
    $order_details = $$db->order_details;


    //  CRUD ///////////////////////////
//INSERT
    $insertCustomer = $user->insertOne([ 
        'Title' => 'Mr', 
        'First_names(s)' => 'Harold', 
        'Surname' => 'Higgs', 
        'Mobile' => '000987654321', 
        'Email' => 'h.h23@gmail.com'
        ] );
    printf("Inserted %d document(s)\n", $insertCustomer->getInsertedCount());
    var_dump($insertCustomer->getInsertedId());
//---------------------------------------------------------------
    $insertItem = $item_details->insertOne([ 
        'manufacturer' => 'Nokia', 
        'model' => 'Nokia 7.2', 
        'price' => 280, 
        ] );
    printf("Inserted %d document(s)\n", $insertItem->getInsertedCount());
    var_dump($insertItem->getInsertedId());
//---------------------------------------------------------------
    $insertOrder = $orderdetails->insertOne([ 
        'purchase' => ['Iphone 10', 'Airpods'], 
        'customer' => 'Harold'
        ] );
    printf("Inserted %d document(s)\n", $insertOrder->getInsertedCount());
    var_dump($insertOrder->getInsertedId());

//FIND
    $findCustomer = $user->find(['First_names(s)' => 'Viktorija']);

    foreach ($findCustomer as $document) {
        echo $document['Title'], " ", $document['First_names(s)'], " ", $document['Surname'], ", ", $document['Mobile'], ", ", $document['Email'], " \n";
    }
//---------------------------------------------------------------
    $findItem = $item_details->find(['model' => 'Samsung Galaxy 8']);

    foreach ($findItem as $document) {
        echo $document['manufacturer'], ", ", $document['model'], ", ", $document['price'], " \n";
    }
//---------------------------------------------------------------
    $findOrder = $order_details->find(['customer' => 'Viktorija']);

    foreach ($findOrder as $document) {
        echo $document['purchase'], ", ", $document['customer'], " \n";
    }

//UPDATE
    $rand = mysqli_query($user,"SELECT * FROM First_names(s) order by RAND() limit 5");
    $updateCustomer = $user->updateOne(
        ['First_names(s)' => $rand],
        ['$set' => ['Title' => 'Mx'], 
            ['Mobile' => '000'], 
            ['Email' => 'nobody@nowhere.com']
        ]
    );
    printf("Matched %d document(s)\n", $updateCustomer->getMatchedCount());
    printf("Modified %d document(s)\n", $updateCustomer->getModifiedCount());
//---------------------------------------------------------------
    $rand = mysqli_query($item_details,"SELECT * FROM model order by RAND() limit 5");
    $updateItem = $item_details->updateOne(
        ['model' => $rand],
        ['$set' => ['manufacturer' => 'Sony'], 
            ['price' => 50]
        ]
    );
    printf("Matched %d document(s)\n", $updateItem->getMatchedCount());
    printf("Modified %d document(s)\n", $updateItem->getModifiedCount());
//---------------------------------------------------------------
    $rand = mysqli_query($order_details,"SELECT * FROM customer order by RAND() limit 5");
    $updateOrder = $order_details->updateOne(
        ['customer' => $rand],
        ['$set' => ['purchase' => ['Airpods','ChargerA','Iphone 10']]]
    );
    printf("Matched %d document(s)\n", $updateOrder->getMatchedCount());
    printf("Modified %d document(s)\n", $updateOrder->getModifiedCount());

//DELETE
    $deleteCustomer = $user->deleteOne(
        ['Email' => 'user@email.com'], 
        ['Mobile' => '666'],
        ['First_name(s)' => 'Jane'],
        ['Surname' => 'Doe']);
    printf("Deleted %d document(s)\n", $deleteCustomer->getDeletedCount());
//---------------------------------------------------------------
    $deleteItem = $item_details->deleteOne(
        ['manufacturer' => 'Samsung'], 
        ['model' => 'Samsung Galaxy 10'],
        ['price' => 150]);
    printf("Deleted %d document(s)\n", $deleteItem->getDeletedCount());
//---------------------------------------------------------------
    $deleteOrder = $collection->deleteOne(
        ['customer' => 'Bobby'], 
        ['purchase' => ['Samsung Galaxy 8']]);
    printf("Deleted %d document(s)\n", $deleteOrder->getDeletedCount());

?>

<!-- I used a relational model database, this means I formed relationships between tables by joining them 
    I did this by using the aggregate function $lookup to join collections in MongoDB

-->
