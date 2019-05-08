# Form Data to Google Sheets

OpenWhisk serverless PHP action to store data from an HTML form into Google Sheets.


# Set up

1. Install the [Serverless Framework](https://serverless.com)

    ```shell
    $ npm install --global serverless serverless-openwhisk
    ```

2. Set up IBM Cloud Functions and log into the correct organisation and space.
   Ensure you can run:

    ```shell
    $ wsk api list
    ```

    (This will ensure that the `~/.wskprops` file is up-to-date; it contains the relevant API keys that are used by Serverless when deploying.)



3. Clone this repo(!)

4. Run the package manager:

    ```shell
    $ npm install
    ```

5. Set up the Google Sheet as per [David McCoy's article][1]

6. Set the SHEETS_URL environment variable to the URL:

    ```shell
    $ export SHEETS_URL=https://script.google.com/macros/s/{stuff}/exec
    ```

6. Deploy the API using the `sls` command:

    ```shell
    $ sls deploy
    ```

7. Prove it works:

    ```shell
    $ curl "https://openwhisk.eu-gb.bluemix.net/api/v1/web/YOUR_NAMESPACE/ow-php-form-to-google-sheets/submit.http" \
     -d "firstname=Rob" -d "lastname=Allen" -d "email=rob@example.com"
    ```

    There should now be a new row in the Google Sheet.



## Reference

* Google Sheets integration from [David McCoy's article][1].




[1]: https://medium.com/@dmccoy/how-to-submit-an-html-form-to-google-sheets-without-google-forms-b833952cc175
