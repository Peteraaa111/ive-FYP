package android.exercise.travelhk;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.DocumentSnapshot;
import com.google.firebase.firestore.FirebaseFirestore;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Activity_Login extends AppCompatActivity{

    private PreferenceManager preferenceManager;
    private Button btnLogin;
    private TextView txtEmail, txtPsw;
    private String email = "", psw = "";
    private String accountid,emailsave,nickname,phone,id,passowrd;
    int type;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        preferenceManager = new PreferenceManager(getApplicationContext());
        setContentView(R.layout.activity_login);
        txtEmail = findViewById(R.id.txtEmail);
        txtPsw = findViewById(R.id.txtPassword);
        btnLogin = findViewById(R.id.btnLogin);
      }


    public void login(View v) {
        email = txtEmail.getText().toString().trim();
        psw = txtPsw.getText().toString().trim();
        if(!email.equals("")&& !psw.equals("")){
            StringRequest stringRequest = new StringRequest(Request.Method.POST, "http://192.168.1.18/android/login.php"
                 , new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                        if(!response.equals("fail")){
                        try {
                            JSONObject object = new JSONObject(response);
                            accountid = object.getString("accID");
                            passowrd = object.getString("password");
                            emailsave = object.getString("email");
                            nickname = object.getString("nick");
                            phone = object.getString("phone");
                            type = object.getInt("type");

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        if (type == 5) {
                            addDataToFirestore();
                            preferenceManager.putBoolean("isLogin",true);
                            preferenceManager.putString("userID",accountid);
                            preferenceManager.putString("name",nickname);
                            preferenceManager.putString("phone",phone);
                            preferenceManager.putString("email",emailsave);
                            preferenceManager.putString("password",passowrd);
                            preferenceManager.putInt("type",type);
                            Intent intent = new Intent(Activity_Login.this, Driver.class);
                            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
                            startActivity(intent);
                            finish();
                        } else if (type == 1) {
                            addDataToFirestore();
                            preferenceManager.putBoolean("isLogin",true);
                            preferenceManager.putString("userID",accountid);
                            preferenceManager.putString("name",nickname);
                            preferenceManager.putString("phone",phone);
                            preferenceManager.putString("email",emailsave);
                            preferenceManager.putString("password",passowrd);
                            preferenceManager.putInt("type",type);
                            Intent intent = new Intent(Activity_Login.this, User.class);
                            intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
                            startActivity(intent);
                            finish();
                        }else if(type == 2 || type==3 || type==0 || type==4) {
                            Log.d("res", response);
                            Toast.makeText(Activity_Login.this, "手機版只限普通用戶和司機使用", Toast.LENGTH_SHORT).show();
                        }
                        }else if(response.equals("fail")){
                            Toast.makeText(Activity_Login.this, "錯誤電郵或密碼", Toast.LENGTH_SHORT).show();
                        }
                }


            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(Activity_Login.this, error.toString().trim(), Toast.LENGTH_SHORT).show();
                }
            }){
                @Override
                protected Map<String, String> getParams() throws AuthFailureError {
                    Map<String, String> data = new HashMap<>();
                    data.put("email", email);
                    data.put("password", psw);
                    return data;
                }
            };
            RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
            requestQueue.add(stringRequest);
        }else{
            Toast.makeText(this, "輸入欄不能為空格!", Toast.LENGTH_SHORT).show();
        }
    }


        public void addDataToFirestore(){
        FirebaseFirestore database = FirebaseFirestore.getInstance();
        database.collection("users")
                .whereEqualTo("accountID",accountid)
                .get()
                .addOnCompleteListener(task -> {
                    if (task.isSuccessful() && task.getResult()!=null
                            && task.getResult().getDocuments().size()>0){
                        DocumentSnapshot documentSnapshot = task.getResult().getDocuments().get(0);
                        id = documentSnapshot.getId();
                        DocumentReference documentReference =
                                database.collection("users").document
                                        (id);
                        documentReference.update(Constants.KEY_AVAILABILITY,1);
                        preferenceManager.putString(Constants.KEY_USER_ID,id);
                    } else{
                        HashMap<String, Object> data = new HashMap<>();
                        data.put("accountID",accountid);
                        data.put("email",emailsave);
                        data.put("name",nickname);
                        data.put("type",type);
                        data.put("phone",phone);
                        data.put("availability",1);
                        database.collection("users").add(data).addOnSuccessListener(documentReference -> {
                            //Toast.makeText(getApplicationContext(),"Data Inserted",Toast.LENGTH_SHORT).show();
                        });
                    }

            });

    }





}