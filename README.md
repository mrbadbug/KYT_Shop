# KYT_Shop
**Integrate Database with Xampp:**

1. Create database for kyt_shop;
   use kyt_shop;

3. create table for users{
   id;
   username;
   full_name;
   email;
   password_hash;
   phone
   }

4. create table for orders{
   id;
   user_id;
   total_amount;
   shipping_info;
   products_json;
   order_date
   }  

5. create table for products{
   id;
   name;
   description;
   price;
   image_url (Given in the static/images folder)
   }  

5. insert products into products{}

6. now put your project folder into xampp/htdocs, open xampp, start Apache, MySQL and paste project folder name into url and run.

**Future Improvements(working with it):**
 - Modern UI
 - Custom animations
 - Search bar
 - More functionalities 
 - admin control
