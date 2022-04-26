package android.exercise.travelhk;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.AppCompatImageView;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.firebase.database.FirebaseDatabase;

import java.util.HashMap;
import java.util.Map;

public class DetailedOrdersActivity extends AppCompatActivity {

    PreferenceManager preferenceManager;
    private TextView GstartAddress, GendAddress,GstartDate,GstartTime,GpeopleNumber,GbookingId;
    private String url = "http://192.168.1.18/android/acceptOrder.php";
    AppCompatImageView back;
    private String bookingId,accountid;
    private Button accept;
    private String email;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detailed_orders);
        preferenceManager = new PreferenceManager(getApplicationContext());
        GstartAddress = findViewById(R.id.startAddress1);
        GendAddress = findViewById(R.id.endAddress1);
        GstartDate = findViewById(R.id.startDate1);
        GstartTime = findViewById(R.id.startTime1);
        GpeopleNumber = findViewById(R.id.peopleNumber1);
        GbookingId = findViewById(R.id.bookingID1);
        back = findViewById(R.id.BackPage);
        accept = findViewById(R.id.accpetOrder);
        back.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(DetailedOrdersActivity.this, DriverHomePage.class);
                startActivity(intent);
            }
        });
        // Catching incoming intent
        Intent intent = getIntent();
        String startAddress = intent.getStringExtra("startAddress");
        String endAddress = intent.getStringExtra("endAddress");
        String startDate = intent.getStringExtra("startDate");
        String startTime = intent.getStringExtra("startTime");
        String peopleNumber = intent.getStringExtra("peopleNumber");
        bookingId = intent.getStringExtra("bookingId");
        email = intent.getStringExtra("email");
        accountid = intent.getStringExtra("accountid");
        if (intent !=null){
            GbookingId.setText("編號: "+bookingId);
            GstartAddress.setText("起點: "+startAddress);
            GendAddress.setText("終點: "+endAddress);
            GstartDate.setText("日期: "+startDate);
            GstartTime.setText("時間: "+startTime);
            GpeopleNumber.setText("人數: "+peopleNumber);
        }

        accept.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                alertDialog();
            }
        });
    }

    public void acceptOrder() {
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url
                    , new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(response.equals("success")){
                        FirebaseDatabase.getInstance().getReference(bookingId)
                        .child(preferenceManager.getString("userID"))
                        .child("email")
                        .setValue(preferenceManager.getString("email"));
                        FirebaseDatabase.getInstance().getReference(bookingId)
                        .child(accountid)
                        .child("email")
                        .setValue(email);
                        Intent intent = new Intent(DetailedOrdersActivity.this, DriverHomePage.class);
                        startActivity(intent);
                        Toast.makeText(DetailedOrdersActivity.this,"Accept Order Successful",Toast.LENGTH_SHORT).show();
                    }else if(response.equals("fail")){
                        Toast.makeText(DetailedOrdersActivity.this, "Invalid", Toast.LENGTH_SHORT).show();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(DetailedOrdersActivity.this, error.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }){
                @Override
                protected Map<String, String> getParams() throws AuthFailureError {
                    Map<String, String> data = new HashMap<>();
                    data.put("driver_id", preferenceManager.getString("userID"));
                    data.put("booking_id", bookingId);
                    return data;
                }
            };
            RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
            requestQueue.add(stringRequest);
    }

    public void alertDialog(){
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setMessage("確定接單?");
        builder.setPositiveButton("確定", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {
                acceptOrder();
            }
        });
        builder.setNegativeButton("取消", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialogInterface, int i) {

            }
        });
        builder.create();
        builder.show();
    }


}
