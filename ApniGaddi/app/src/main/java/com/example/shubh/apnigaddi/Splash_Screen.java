package com.example.shubh.apnigaddi;

import android.animation.Animator;
import android.animation.AnimatorSet;
import android.animation.ObjectAnimator;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.database.Cursor;
import android.database.DatabaseUtils;
import android.os.AsyncTask;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.TranslateAnimation;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.Toast;

import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Random;

public class Splash_Screen extends AppCompatActivity {

    ImageView logo;
    Button welcome;
    RelativeLayout relativeLayout;
    Intent intent;
    SQLiteManager sqlitem;
    String em = null;
    String ps = null;
    JSONParser jsonParser =new JSONParser();
    String URL = "https://myideawork.000webhostapp.com/API/Login/Login.php";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash__screen);
        getSupportActionBar().hide();
        logo = (ImageView)findViewById(R.id.logo);
        welcome = (Button)findViewById(R.id.welcome);
        relativeLayout = (RelativeLayout) findViewById(R.id.splash);
        sqlitem = new SQLiteManager(getApplicationContext());
        if (ContextCompat.checkSelfPermission(getApplicationContext(), android.Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(getApplicationContext(), android.Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {

            ActivityCompat.requestPermissions(this, new String[]{android.Manifest.permission.ACCESS_FINE_LOCATION, android.Manifest.permission.ACCESS_COARSE_LOCATION}, 101);

        }
        welcome.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(final View v) {

                int check = sqlitem.gettablelogin();
                if(check == 1)
                {
                    Cursor data = sqlitem.getuserlogin();
                    while(data.moveToNext()) {
                        em = data.getString(2);
                        ps = data.getString(3);
                    }

                    AttemptLogin attemptLogin =new AttemptLogin();
                    attemptLogin.execute(em,ps);
                    doSomethingThatTakesALongTime(v);
                }
                else {
                    intent = new Intent(getApplicationContext(), Login.class);
                    startActivity(intent);
                    finish();
                }
            }
        });





    }
    public void doSomethingThatTakesALongTime(View v) {
        new VeryLongAsyncTask(this).execute();
    }

    //Resposible for auto-login through JSON

    private class AttemptLogin extends AsyncTask<String,String,JSONObject> {

        @Override

        protected void onPreExecute() {

            super.onPreExecute();

        }

        @Override
        protected JSONObject doInBackground(String... strings) {
            String emailholder = strings[0];
            String passholder = strings[1];

            ArrayList params = new ArrayList();
            params.add(new BasicNameValuePair("email", emailholder));
            params.add(new BasicNameValuePair("password", passholder));

            JSONObject json = jsonParser.makeHttpRequest(URL, "POST", params);

            return json;
        }

        protected void onPostExecute(JSONObject result) {

            // dismiss the dialog once product deleted
            //Toast.makeText(getApplicationContext(),result,Toast.LENGTH_LONG).show();

            try {
                if (result != null) {
                    Toast.makeText(getApplicationContext(),result.getString("message"),Toast.LENGTH_LONG).show();
                    intent = new Intent(getApplicationContext(),HomeScreen.class);
                    startActivity(intent);
                    finish();
                } else {
                    Toast.makeText(getApplicationContext(), "Unable to retrieve any data from server", Toast.LENGTH_LONG).show();
                }
            } catch (JSONException e) {
                e.printStackTrace();
            }


        }
    }


    //Resposible for animation loading screen....


    class VeryLongAsyncTask extends AsyncTask<Void, Void, Void> {
        private final ProgressDialog progressDialog;

        public VeryLongAsyncTask(Context ctx) {
            progressDialog = LoadingScreen.ctor(ctx);
        }

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            //textView.setVisibility(View.INVISIBLE);

            progressDialog.show();
        }

        @Override
        protected Void doInBackground(Void... params) {
            // sleep for 5 seconds
            try { Thread.sleep(100000); }
            catch (InterruptedException e) { e.printStackTrace(); }

            return null;
        }

        @Override
        protected void onPostExecute(Void result) {
            super.onPostExecute(result);
            //textView.setVisibility(View.VISIBLE);

            progressDialog.dismiss();
        }
    }

}
