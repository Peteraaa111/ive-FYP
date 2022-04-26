package android.exercise.travelhk;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.AppCompatImageView;
import androidx.core.app.ActivityCompat;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.SupportMapFragment;

import android.Manifest;
import android.annotation.SuppressLint;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.gms.maps.model.Polyline;
import com.google.android.gms.maps.model.PolylineOptions;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.Query;
import com.google.firebase.database.ValueEventListener;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import directionhelpers.FetchURL;
import directionhelpers.TaskLoadedCallback;

public class MapActivity extends AppCompatActivity implements OnMapReadyCallback,LocationListener, TaskLoadedCallback {
    private String url = "http://192.168.1.18/android/finishedWork.php";
    SupportMapFragment mapFragment;
    private GoogleMap map;
    FusedLocationProviderClient client;
    private PreferenceManager preferenceManager;
    private Button finishedWork;
    Location mlocation;
    AppCompatImageView back;
    TextView detail,detail2;
    Marker mCurrentLocationMarker;
    Marker mOtherLocationMarker;
    Polyline currentPolyline;
    private String bookingid;
    private DatabaseReference reference,Location;
    private int type;
    private LocationManager manager;
    private final int MIN_TIME = 5000; //5second
    private ArrayList<MyLocation>list = new ArrayList<>();
    private final int MIN_DISTANCE = 1;
    Handler handler = new Handler();
    Runnable runnable;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_maps);
        preferenceManager = new PreferenceManager(getApplicationContext());
        back = findViewById(R.id.Back);
        finishedWork = findViewById(R.id.finishedWork);
        client = LocationServices.getFusedLocationProviderClient(this);
        manager = (LocationManager) getSystemService(LOCATION_SERVICE);
        mapFragment = (SupportMapFragment) getSupportFragmentManager().findFragmentById(R.id.map);
        //Location = FirebaseDatabase.getInstance().getReference().child("Locations");
        mapFragment.getMapAsync(this);
        detail = findViewById(R.id.Detail);
        detail2 = findViewById(R.id.Detail2);
        type = preferenceManager.getInt("type");
        getDetail();
        getLocationUpdates();
        loadDatabase();
        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(type==1){
                    Intent i = new Intent(MapActivity.this, UserSchedulePage.class);
                    startActivity(i);
                }else if(type==5){
                    Intent i = new Intent(MapActivity.this, DriverSchedulePage.class);
                    startActivity(i);
                }
            }
        });

        finishedWork.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                alertDialog();
            }
        });
    }

    public void queryData(){
        Query query = reference.orderByChild("email");
        query.addListenerForSingleValueEvent(new ValueEventListener() {
            public void onDataChange(DataSnapshot dataSnapshot) {
                if (dataSnapshot.exists()) {
                    list.clear();
                    for (DataSnapshot location : dataSnapshot.getChildren()) {
                        MyLocation location1 = new MyLocation();
                        location1.setLocation(location);
                        list.add(location1);
                    }
                    markLocation(list);
                    getCurrentLocation();
                    drawRoute();
                }
            }
            @Override
            public void onCancelled(@NonNull DatabaseError error) {

            }
        });
    }


    public void drawRoute(){
        LatLng l1 = new LatLng(list.get(0).getLatitude(),list.get(0).getLogitude());
        LatLng l2 = new LatLng(list.get(1).getLatitude(),list.get(1).getLogitude());
        new FetchURL(MapActivity.this).execute(getUrl(l1, l2, "driving"), "driving");
    }

    private void markLocation(ArrayList<MyLocation> arrayList){
            mapFragment.getMapAsync(new OnMapReadyCallback() {
                @Override
                public void onMapReady(@NonNull GoogleMap googleMap) {
                    for (MyLocation item : arrayList) {
                        map = googleMap;
                        if(item.getEmail().equals(preferenceManager.getString("email"))){
                            LatLng latLng = new LatLng(item.getLatitude(), item.getLogitude());
                            MarkerOptions options = new MarkerOptions().position(latLng)
                                    .title(item.getEmail())
                                    .icon(BitmapDescriptorFactory.defaultMarker(BitmapDescriptorFactory.HUE_RED));
                            if(mCurrentLocationMarker!=null){
                                mCurrentLocationMarker.remove();
                            }
                            mCurrentLocationMarker = map.addMarker(options);
                        }else {
                            LatLng latLng2 = new LatLng(item.getLatitude(), item.getLogitude());
                            MarkerOptions options2 = new MarkerOptions().position(latLng2)
                                    .title(item.getEmail())
                                    .icon(BitmapDescriptorFactory.defaultMarker(BitmapDescriptorFactory.HUE_BLUE));
                            if(mOtherLocationMarker!=null){
                                mOtherLocationMarker.remove();
                            }
                             if(!(item.getLatitude() == (double) 0) && !(item.getLogitude() == (double) 0)){
                                mOtherLocationMarker = map.addMarker(options2);
                            }

                        }
                    }
                }
            });
    }

    private void getCurrentLocation(){
        @SuppressLint("MissingPermission") Task<Location> task = client.getLastLocation();
        task.addOnSuccessListener(new OnSuccessListener<Location>() {
            @Override
            public void onSuccess(Location location) {
                if(location!=null){
                    mapFragment.getMapAsync(new OnMapReadyCallback() {
                        @Override
                        public void onMapReady(@NonNull GoogleMap googleMap) {
                            map = googleMap;
                            LatLng latLng = new LatLng(location.getLatitude(),location.getLongitude());
                            map.animateCamera(CameraUpdateFactory.newLatLngZoom(latLng,17));
                            reference.child(preferenceManager.getString("userID")).child("lat").setValue(location.getLatitude());
                            reference.child(preferenceManager.getString("userID")).child("lng").setValue(location.getLongitude());
                        }
                    });
                }
            }
        });
    }

    //new FetchURL(MapActivity.this).execute(getUrl(options.getPosition(), options2.getPosition(), "driving"), "driving");

    private String getUrl(LatLng origin, LatLng dest, String directionMode) {
        // Origin of route
        String str_origin = "origin=" + origin.latitude + "," + origin.longitude;
        // Destination of route
        String str_dest = "destination=" + dest.latitude + "," + dest.longitude;
        // Mode
        String mode = "mode=" + directionMode;
        // Building the parameters to the web service
        String parameters = str_origin + "&" + str_dest + "&" + mode;
        // Output format
        String output = "json";
        // Building the url to the web service
        String url = "https://maps.googleapis.com/maps/api/directions/" + output + "?" + parameters + "&key=AIzaSyCZcU0QmYippxvgWYlXJOq8h9hPcbfBxyc";
        return url;
    }

    @Override
    public void onTaskDone(Object... values) {
        if (currentPolyline != null)
            currentPolyline.remove();
        currentPolyline = map.addPolyline((PolylineOptions) values[0]);
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == 101) {
            if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                getLocationUpdates();

            } else {
                Toast.makeText(this, "Permission Required", Toast.LENGTH_SHORT).show();
            }
        }
    }


    @Override
    public void onMapReady(@NonNull GoogleMap googleMap) {
        map = googleMap;
        map.getUiSettings().setZoomControlsEnabled(true);
        map.getUiSettings().setAllGesturesEnabled(true);
    }

    private void getLocationUpdates() {
        if (manager != null) {
            if (ActivityCompat.checkSelfPermission(this,
                    Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED &&
                    ActivityCompat.checkSelfPermission(this,Manifest.permission.ACCESS_COARSE_LOCATION)
                    == PackageManager.PERMISSION_GRANTED) {
                if (manager.isProviderEnabled(LocationManager.GPS_PROVIDER)) {
                    manager.requestLocationUpdates(LocationManager.GPS_PROVIDER, MIN_TIME, MIN_DISTANCE, this);
                } else if (manager.isProviderEnabled(LocationManager.NETWORK_PROVIDER)) {
                    manager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, MIN_TIME, MIN_DISTANCE, this);
                } else {
                    Toast.makeText(this, "No Provider Enabled", Toast.LENGTH_SHORT).show();
                }
            }else{
                ActivityCompat.requestPermissions(this,new String[]{Manifest.permission.ACCESS_FINE_LOCATION},101);
            }
        }
    }



    @Override
    public void onLocationChanged(@NonNull Location location) {
        mlocation = location;
        reference.child(preferenceManager.getString("userID")).child("lat").setValue(location.getLatitude());
        reference.child(preferenceManager.getString("userID")).child("lng").setValue(location.getLongitude());
    }

    public void loadDatabase(){
        handler.postDelayed(runnable = new Runnable() {
            @Override
            public void run() {
                handler.postDelayed(runnable,MIN_TIME);
                queryData();
            }
        }, MIN_TIME);
    }

    public void getDetail(){
        Intent intent = getIntent();
        String detailName;
        String detailPhone;
        bookingid = intent.getStringExtra("bookingId");
        reference = FirebaseDatabase.getInstance().getReference().child(bookingid);
        if(type==1){
            detailName = intent.getStringExtra("driverName");
            detailPhone = intent.getStringExtra("driverPhone");
            detail.setText("司機名稱: "+detailName);
            detail2.setText("聯絡方式: "+detailPhone);
        }else if(type ==5){
            detailName = intent.getStringExtra("userName");
            detailPhone = intent.getStringExtra("userPhone");
            finishedWork.setVisibility(View.VISIBLE);
            detail.setText("客戶名稱: "+detailName);
            detail2.setText("聯絡方式: "+detailPhone);
        }
    }


    public void alertDialog(){
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setMessage("接載完成?");
        builder.setPositiveButton("完成", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                finishedWork();
            }
        });
        builder.setNegativeButton("未完成", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {

            }
        });
        builder.create();
        builder.show();
    }



    public void finishedWork(){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url
                , new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                if(response.equals("success")){
                    Intent intent = new Intent(MapActivity.this, DriverHomePage.class);
                    startActivity(intent);
                    Toast.makeText(MapActivity.this,"已經成功完成訂單",Toast.LENGTH_SHORT).show();
                }else if(response.equals("fail")){
                    Toast.makeText(MapActivity.this, "Invalid", Toast.LENGTH_SHORT).show();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(MapActivity.this, error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> data = new HashMap<>();
                data.put("booking_id", bookingid);
                return data;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
        requestQueue.add(stringRequest);
    }

}