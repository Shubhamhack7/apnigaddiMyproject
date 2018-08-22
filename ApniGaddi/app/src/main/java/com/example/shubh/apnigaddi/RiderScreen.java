package com.example.shubh.apnigaddi;

import android.Manifest;
import android.content.Context;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Color;
import android.graphics.drawable.Drawable;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.FragmentActivity;
import android.os.Bundle;
import android.support.v4.content.ContextCompat;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.RadioButton;
import android.widget.Toast;

import com.google.android.gms.maps.CameraUpdate;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptor;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.CameraPosition;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.maps.model.PolylineOptions;

import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;


public class RiderScreen extends FragmentActivity implements OnMapReadyCallback {

    public GoogleMap mMap;
    public GPSTracker gpsTracker;
    public EditText editText;
    public Button search;
    public String addr;
    public LatLng dest=null;
    public LatLng mylocation=null;
    public String URL;
    public ImageButton myloc;
    public Button confirm;
    String Server_URL ="https://myideawork.000webhostapp.com/API/Rider.php";
    JSONParser jsonParser =new JSONParser();
    private double dest_lati;
    private double dest_long;
    private Calendar calendar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_rider_screen);
        editText =(EditText)findViewById(R.id.area);
        search = (Button) findViewById(R.id.searchbuttonn);
        myloc = (ImageButton)findViewById(R.id.mylocations);
        confirm = (Button)findViewById(R.id.confirmbuttron);
        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);
        gpsTracker = new GPSTracker(getApplicationContext());
        myloc.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onMapReady(mMap);
            }
        });

        confirm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AttemptLogin attemptLogin =new AttemptLogin();
                String d =getCurrentDate();
                String t = getCurrentTime();
                attemptLogin.execute("MO9346096",String.valueOf(gpsTracker.latitude),String.valueOf(gpsTracker.longitude),String.valueOf(dest_lati),String.valueOf(dest_long),d,t);
            }
        });
        search.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(editText.getText().toString().isEmpty()) {
                    Toast.makeText(getApplicationContext(),"Please Search the Landmark",Toast.LENGTH_LONG).show();
                }
                else
                {
                    mMap.clear();
                    onMapReady(mMap);
                    dest = getLocationFromAddress(getApplicationContext(), editText.getText().toString());
                    editText.setText(null);
                    URL = getMapsApiDirectionsUrl(mylocation, dest);
                    ReadTask downloadTask = new ReadTask();
                    downloadTask.execute(URL);
                    MarkerOptions marker = new MarkerOptions().position(dest).title("Destination");
                    marker.icon(BitmapDescriptorFactory.defaultMarker());
                    mMap.addMarker(marker);
                }
            }
        });

    }

    public String getCurrentTime() {
        Calendar calendar = Calendar.getInstance();
        SimpleDateFormat mdformat = new SimpleDateFormat("HH:mm:ss");
        String strDate = mdformat.format(calendar.getTime());
        return strDate;
    }
    public String getCurrentDate() {
        Calendar calendar = Calendar.getInstance();
        String strDate = calendar.get(Calendar.DAY_OF_MONTH)+":"+calendar.get(Calendar.MONTH)+":"+calendar.get(Calendar.YEAR);
        return strDate;
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;
        if(gpsTracker.canGetLocation)
        {
            Log.e("GPS Enabled"," ");
            double lat =gpsTracker.latitude;
            double lon =gpsTracker.longitude;
            Log.e("LatLong",""+ lat + "  :  " + lon);
            mylocation = new LatLng(lat,lon);
            MarkerOptions marker = new MarkerOptions().position(new LatLng(lat,lon)).title("You are here");
            marker.icon(BitmapDescriptorFactory.fromBitmap(resizeMapIcons("ridermarker",60,60)));
            mMap.addMarker(marker);
            //mMap.moveCamera(CameraUpdateFactory.newLatLng(mylocation));
            CameraPosition cameraPosition = new CameraPosition.Builder()
                    .target(mylocation)      // Sets the center of the map to Mountain View
                    .zoom(17)                   // Sets the zoom
                    .bearing(90)                // Sets the orientation of the camera to east
                    .tilt(30)                   // Sets the tilt of the camera to 30 degrees
                    .build();                   // Creates a CameraPosition from the builder
            mMap.animateCamera(CameraUpdateFactory.newCameraPosition(cameraPosition));


        }
    }

    public LatLng getLocationFromAddress(Context context,String strAddress) {

        Geocoder coder = new Geocoder(context);
        List<Address> address;
        LatLng p1 = null;

        try {
            // May throw an IOException
            address = coder.getFromLocationName(strAddress, 5);
            if (address == null) {
                return null;
            }

            Address location = address.get(0);
            dest_lati = location.getLatitude();
            dest_long = location.getLongitude();
            p1 = new LatLng(location.getLatitude(), location.getLongitude() );

        } catch (IOException ex) {

            ex.printStackTrace();
        }

        return p1;
    }

    public Bitmap resizeMapIcons(String iconName,int width, int height){
        Bitmap imageBitmap = BitmapFactory.decodeResource(getResources(),getResources().getIdentifier(iconName, "drawable", getPackageName()));
        Bitmap resizedBitmap = Bitmap.createScaledBitmap(imageBitmap, width, height, false);
        return resizedBitmap;
    }

    private String  getMapsApiDirectionsUrl(LatLng origin,LatLng dest) {
        // Origin of route
        String str_origin = "origin="+origin.latitude+","+origin.longitude;

        // Destination of route
        String str_dest = "destination="+dest.latitude+","+dest.longitude;


        // Sensor enabled
        String sensor = "sensor=false";

        // Building the parameters to the web service
        String parameters = str_origin+"&"+str_dest+"&"+sensor;

        // Output format
        String output = "json";

        // Building the url to the web service
        String url = "https://maps.googleapis.com/maps/api/directions/"+output+"?"+parameters;


        return url;

    }
    private class ReadTask extends AsyncTask<String, Void, String> {
        @Override
        protected String doInBackground(String... url) {
            String data = "";
            try {
                HttpConnection http = new HttpConnection();
                data = http.readUrl(url[0]);
            } catch (Exception e) {
                Log.d("Background Task", e.toString());
            }
            return data;
        }

        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);
            new ParserTask().execute(result);
        }
    }

    private class ParserTask extends AsyncTask<String, Integer, List<List<HashMap<String, String>>>> {

        @Override
        protected List<List<HashMap<String, String>>> doInBackground(
                String... jsonData) {

            JSONObject jObject;
            List<List<HashMap<String, String>>> routes = null;

            try {
                jObject = new JSONObject(jsonData[0]);
                PathJSONParser parser = new PathJSONParser();
                routes = parser.parse(jObject);
            } catch (Exception e) {
                e.printStackTrace();
            }
            return routes;
        }

        @Override
        protected void onPostExecute(List<List<HashMap<String, String>>> routes) {
            ArrayList<LatLng> points = null;
            PolylineOptions polyLineOptions = null;

            // traversing through routes
            for (int i = 0; i < routes.size(); i++) {
                points = new ArrayList<LatLng>();
                polyLineOptions = new PolylineOptions();
                List<HashMap<String, String>> path = routes.get(i);

                for (int j = 0; j < path.size(); j++) {
                    HashMap<String, String> point = path.get(j);

                    double lat = Double.parseDouble(point.get("lat"));
                    double lng = Double.parseDouble(point.get("lng"));
                    LatLng position = new LatLng(lat, lng);

                    points.add(position);
                }

                polyLineOptions.addAll(points);
                polyLineOptions.width(5);
                polyLineOptions.color(Color.BLUE);
            }

            mMap.addPolyline(polyLineOptions);
        }
    }

    private class AttemptLogin extends AsyncTask<String,String,JSONObject> {

        @Override

        protected void onPreExecute() {

            super.onPreExecute();

        }

        @Override
        protected JSONObject doInBackground(String... strings) {
            String uidholder = strings[0];
            String clati = strings[1];
            String clong = strings[2];
            String dlati = strings[3];
            String dlong = strings[4];
            String date = strings[5];
            String time = strings[6];

            ArrayList params = new ArrayList();
            params.add(new BasicNameValuePair("uid", uidholder));
            params.add(new BasicNameValuePair("current_lati", clati));
            params.add(new BasicNameValuePair("current_long", clong));
            params.add(new BasicNameValuePair("destination_lati", dlati));
            params.add(new BasicNameValuePair("destination_long", dlong));
            params.add(new BasicNameValuePair("date", date));
            params.add(new BasicNameValuePair("time", time));

            JSONObject json = jsonParser.makeHttpRequest(Server_URL, "POST", params);

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


