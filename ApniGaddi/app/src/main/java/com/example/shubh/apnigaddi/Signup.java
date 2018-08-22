package com.example.shubh.apnigaddi;

import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Toast;

import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class Signup extends AppCompatActivity {

    ImageButton register;
    EditText name,username,password,email,phoneno;
    RadioGroup radioGroup;
    String URL ="https://myideawork.000webhostapp.com/API/Registration/Registration.php";
    JSONParser jsonParser =new JSONParser();
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup);
        getSupportActionBar().hide();
        radioGroup= (RadioGroup)findViewById(R.id.gender);
        register = (ImageButton)findViewById(R.id.signupbutton);
        name = (EditText) findViewById(R.id.fullname);
        username = (EditText) findViewById(R.id.username);
        password = (EditText) findViewById(R.id.password);
        email = (EditText) findViewById(R.id.email);
        phoneno = (EditText) findViewById(R.id.phoneno);

        register.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AttemptLogin attemptLogin =new AttemptLogin();
                int genid = radioGroup.getCheckedRadioButtonId();
                RadioButton radioButton = (RadioButton) findViewById(genid);
                String gender=radioButton.getText().toString();
                attemptLogin.execute(name.getText().toString(),username.getText().toString(),password.getText().toString(),gender,email.getText().toString(),phoneno.getText().toString(),"5555555555");
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
            String nameholder = strings[0];
            String usernameholder = strings[1];
            String passholder = strings[2];
            String gender = strings[3];
            String emailholder = strings[4];
            String phonenoholder = strings[5];
            String adharnoholder = strings[6];

            ArrayList params = new ArrayList();
            params.add(new BasicNameValuePair("name", nameholder));
            params.add(new BasicNameValuePair("username", usernameholder));
            params.add(new BasicNameValuePair("password", passholder));
            params.add(new BasicNameValuePair("gender", gender));
            params.add(new BasicNameValuePair("email", emailholder));
            params.add(new BasicNameValuePair("phoneno", phonenoholder));
            params.add(new BasicNameValuePair("adharno", adharnoholder));

            JSONObject json = jsonParser.makeHttpRequest(URL, "POST", params);

            return json;
        }

        protected void onPostExecute(JSONObject result) {

            // dismiss the dialog once product deleted
            //Toast.makeText(getApplicationContext(),result,Toast.LENGTH_LONG).show();

            try {
                if (result != null) {
                    Toast.makeText(getApplicationContext(),result.getString("message"),Toast.LENGTH_LONG).show();
                } else {
                    Toast.makeText(getApplicationContext(), "Unable to retrieve any data from server", Toast.LENGTH_LONG).show();
                }
            } catch (JSONException e) {
                e.printStackTrace();
            }


        }
    }
}
