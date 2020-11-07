# simple_shopping_cart
Introduction 
This is a simple shopping cart the idea, i used Repository design pattern to isolate dealing with database for each table in it's own Repository Class.
I Made an offer table for each product that have an offer as discount_product and the cinditonal product for the offer if exits main_product otherwise null.
The currency transtion was saved in database and used the ids for each currency to get the factor.
To apply offers:
  first check if  main_product_id is null:
    apply offer on product
   else:
    check if the conditional product exits:
      check the number of products achieved the offer coniditions by dividing the quantity of the main product on the required quantity
      if >= the required number of products:
        apply on all
       else:
        apply on the achieved number only
     else
      original price apply on all.
 
this
Steps:
1- create new database shopping_cart
2- php artisan migrate
3- php artisan seed
4- php artisan serve

Request:
http://localhost:8000/api/checkout

sample body 
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

