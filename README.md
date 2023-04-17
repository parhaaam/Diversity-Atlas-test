# <p style="text-align:center;">DA Test Project</p>


## Deploy and Running the Project

- Make sure `git lfs` has been installed on your machine
- Clone project using  `git lfs clone `
- Copy and edit the example enviroment file from `env.example` , DO NOT CHANGE `DB_DATABASE`!
- Run <pre> docker compose up -d</pre>
- To import the `faker.sql` into mysql container run the following commands <br> Note: <br> Change `DB_USERNAME` , and 
`DB_PASSWORD` to whatever you have been set in `.env`<br> This step may take long time!<pre>docker exec -it mysql /bin/bash <br>mysql -u <i>DB_USERNAME</i> -p<i>DB_PASSWORD</i> laravel < faker.sql</pre>
- Generate Laravel Key <pre>docker exec -it app <br>php artisan key:generate</pre>
- Open `localhost:8888`
