package com.example.shubh.apnigaddi;

import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.RadioButton;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class Login extends AppCompatActivity {

    TextView signup;
    ImageButton imageButton;
    Intent intent;
    EditText emaill,pass;
    SQLiteManager sqLiteManager;
    String UserID;
    String URL = "https://myideawork.000webhostapp.com/API/Login/Login.php";
    JSONParser jsonParser =new JSONParser();
    String e=null;
    String p=null;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        getSupportActionBar().hide();
        signup = (TextView)findViewById(R.id.signup);
        imageButton = (ImageButton)findViewById(R.id.login);
        emaill = (EditText)findViewById(R.id.loginemail);
        pass = (EditText)findViewById(R.id.loginpass);
        sqLiteManager = new SQLiteManager(getApplicationContext());
        imageButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
            e = emaill.getText().toString();
            p = pass.getText().toString();
                Log.e("debugg"," "+ e.length() + " "+ p.length());


                if(e.length()==0||p.length()==0)
                {
                    Toast.makeText(getApplicationContext(),"Fill All details",Toast.LENGTH_LONG).show();
                }
                else
                {

                    AttemptLogin attemptLogin =new AttemptLogin();
                    attemptLogin.execute(e,p);

                }
            }
        });

        signup.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                intent = new Intent(getApplicationContext(),Signup.class);
                startActivity(intent);
                finish();
                return true;
            }
        });

    }

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
                    int check = sqLiteManager.gettablelogin();
                    UserID = result.getString("UID");
                    if(check==0)
                    {
                        sqLiteManager.userLogin(UserID,e,p);
                    }
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
}
