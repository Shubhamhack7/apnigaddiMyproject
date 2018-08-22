package com.example.shubh.apnigaddi;

import android.Manifest;
import android.content.pm.PackageManager;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.FragmentActivity;
import android.os.Bundle;
import android.util.Log;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;

public class PillionScreen extends FragmentActivity implements OnMapReadyCallback {

    private GoogleMap Pillion;
    private GPSTracker gpsTracker;
    LatLng mylocation;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_pillion_screen);
        gpsTracker = new GPSTracker(this);
        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        Pillion = googleMap;
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{android.Manifest.permission.ACCESS_FINE_LOCATION, android.Manifest.permission.ACCESS_COARSE_LOCATION}, 101);
            return;
        }
        Pillion.setMyLocationEnabled(true);

        if(gpsTracker.canGetLocation)
        {
            Log.e("GPS Enabled"," ");
            double lat =gpsTracker.latitude;
            double lon =gpsTracker.longitude;
            Log.e("LatLong",""+ lat + "  :  " + lon);
            mylocation = new LatLng(lat,lon);
            //mMap.moveCamera(CameraUpdateFactory.newLatLng(mylocation));
            CameraPosition cameraPosition = new CameraPosition.Builder()
                    .target(mylocation)      // Sets the center of the map to Mountain View
                    .zoom(15)                   // Sets the zoom
                    .bearing(90)                // Sets the orientation of the camera to east
                    .tilt(30)                   // Sets the tilt of the camera to 30 degrees
                    .build();                   // Creates a CameraPosition from the builder
            Pillion.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));

        }
    }
}
