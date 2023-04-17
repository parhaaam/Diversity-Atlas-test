# <p style="text-align:center;">DA Test Project</p>


## Deploy and Running the Project

- Make sure `git lfs` has been installed on your machine
- Clone project using  `git lfs clone `
- Copy and edit the example enviroment file from `env.example`
- Run <pre> docker compose up -d</pre>
- To import the `faker.sql` into mysql container run the following commands <br> Note: <br> Change `DB_USERNAME` , 
`DB_PASSWORD`, and `DB_DATABASE` to whatever you have been set in `.env`<br> This step may take long time!<pre>docker exec -it /bin/bash <br>mysql -u <i>DB_USERNAME</i> -p<i>DB_PASSWORD</i> <i>DB_DATABASE</i> < faker.sql</pre>
- Generate Laravel Key <pre>docker exec -it app <br>php artisan key:genrate</pre>
- Open `localhost:8888`
