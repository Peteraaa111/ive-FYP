package android.exercise.travelhk;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.bottomnavigation.BottomNavigationView;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;

public class DriverHomePage extends AppCompatActivity {
    private String url = "http://192.168.1.18/android/getBookingOrder.php";
    private RecyclerView.Adapter mAdapter;
    private RecyclerView recyclerView;
    private List<DriverOrder> orders;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.driverhome);
        BottomNavigationView bottomNavigationView =  findViewById(R.id.bottom_nagivation);
        bottomNavigationView.setSelectedItemId(R.id.home);
        recyclerView = findViewById(R.id.my_recycler_view);
        recyclerView.setHasFixedSize(true);
        getOrders();
        orders = new ArrayList<>();

        bottomNavigationView.setOnNavigationItemSelectedListener(new BottomNavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(MenuItem menuItem) {
                switch (menuItem.getItemId()){
                    case R.id.home:
                        startActivity(new Intent(getApplicationContext(), DriverHomePage.class));
                        overridePendingTransition(0, 0);
                        return true;
                    case R.id.Setting:
                        startActivity(new Intent(getApplicationContext(), Setting.class));
                        overridePendingTransition(0, 0);
                        return true;
                    case R.id.user:
                        startActivity(new Intent(getApplicationContext(), Driver.class));
                        overridePendingTransition(0, 0);
                        return true;
                }
                return false;
            }
        });
    }

    public void getOrders(){
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url
                , new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try{
                    JSONArray array = new JSONArray(response);
                    for(int i =0; i<array.length();i++){
                        JSONObject object = array.getJSONObject(i);
                        String startAddress = object.getString("start_address");
                        String endAddress = object.getString("end_address");
                        String startDate = object.getString("start_date");
                        String startTime = object.getString("start_time");
                        String people_num = object.getString("people_num");
                        String bookingId = object.getString("booking_id");
                        String email = object.getString("email");
                        String accountid = object.getString("account_id");
                        DriverOrder order = new DriverOrder(startAddress,endAddress
                                ,startDate,startTime,people_num,bookingId,email,accountid);
                        orders.add(order);
                    }
                }catch (Exception e){
                    e.printStackTrace();
                    Log.d("res",response);
                    Toast.makeText(getApplicationContext(),response,Toast.LENGTH_LONG).show();
                }

                recyclerView.setLayoutManager(new LinearLayoutManager(getApplicationContext()));
                mAdapter = new RecyclerAdapter(DriverHomePage.this,orders);
                recyclerView.setAdapter(mAdapter);

                Log.d("res",response);
            }

        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(DriverHomePage.this,error.toString(),Toast.LENGTH_LONG).show();
            }
        });
        RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
        requestQueue.add(stringRequest);
    }


}







