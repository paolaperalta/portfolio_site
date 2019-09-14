# Gulp Installation 
1. You need to install gulp

    ```
    $ npm install -g gulp
    ```

2. Navigate to the theme folder and install necessary node_modules
    ```
    $ npm install
    ```

3. Edit config.json to change proxy link for BrowserSync.

    ```
    "proxy": "localhost/wp-porto"
    ```

4. Start gulp default task.

    ```
    $ gulp 
    ```

* *Now you can find in terminal link to your project like http://localhost:3000/wp-porto*

* To  prepare the files for productions run:

    ```
    $ gulp build
    ```

Also be happy!


# To edit icon font

1. Open https://icomoon.io/app/#/projects 
2. Import Project from your icomoon cofig (theme-path/fonts/**porto-icon-config.json**)
3. Load uploaded project
4. Import or remove icons
5. When you ready, select all your icons and press Generate Font 
6. Press Download
