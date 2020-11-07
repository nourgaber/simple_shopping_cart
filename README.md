# simple_shopping_cart
Introduction 
<br><br>
This is a simple shopping cart the idea, i used Repository design pattern to isolate dealing with database for each table in it's own Repository Class. <br>

I Made an offer table for each product that have an offer as discount_product and the cinditonal product for the offer if exits main_product otherwise null. <br>

The currency transtion was saved in database and used the ids for each currency to get the factor assuming all prices originally stored in USD. <br>

To apply offers: <br>
  first check if  main_product_id is null: <br>
    apply offer on product <br>
   else: <br>
    check if the conditional product exits: <br>
      check the number of products achieved the offer coniditions by dividing the quantity of the main product on the required quantity <br>
      if >= the required number of products: <br>
        apply on all <br>
       else: <br>
        apply on the achieved number only <br>
     else <br>
      original price apply on all. <br>
 
Steps: <br>
1- create new database shopping_cart  <br>
2- php artisan migrate <br>
3- php artisan seed  <br>
4- php artisan serve <br>

Request:   <br>
http://localhost:8000/api/checkout   <br>

sample body  <br> 
{"products": [
    {
      "id":1,
      "quantity": 5
    },
       {
      "id":3,
      "quantity": 5
    }
    
  ]
}

