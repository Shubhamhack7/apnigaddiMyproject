package com.example.shubh.apnigaddi;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.MotionEvent;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ImageView;

public class HomeScreen extends AppCompatActivity {

    ImageButton rider,pillion;
    Intent intent;
    ImageView userprofile;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home_screen);
        getSupportActionBar().hide();
        rider = (ImageButton)findViewById(R.id.rider);
        pillion = (ImageButton)findViewById(R.id.pillion);
        userprofile = (ImageView)findViewById(R.id.userprofile) ;

        userprofile.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                intent = new Intent(getApplicationContext(),UserProfile.class);
                startActivity(intent);
                finish();
                return false;
            }
        });

        rider.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                intent = new Intent(getApplicationContext(),RiderScreen.class);
                startActivity(intent);
            }
        });
        pillion.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                intent = new Intent(getApplicationContext(),PillionScreen.class);
                startActivity(intent);
            }
        });
    }
}
