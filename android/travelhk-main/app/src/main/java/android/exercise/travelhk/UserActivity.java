package android.exercise.travelhk;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.AppCompatImageView;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.exercise.travelhk.firebase.chat.CUser;
import android.exercise.travelhk.firebase.chat.UserAdapter;
import android.exercise.travelhk.firebase.chat.UserListener;
import android.os.Bundle;
import android.view.View;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.QueryDocumentSnapshot;

import java.util.ArrayList;
import java.util.List;

public class UserActivity extends BaseActivity implements UserListener {
    private RecyclerView recyclerView;
    private ProgressBar progressBar;
    private PreferenceManager preferenceManager;
    private TextView errorMessage;
    private AppCompatImageView backImage;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_user);
        errorMessage = findViewById(R.id.textErrorMessage);
        progressBar = findViewById(R.id.progressBar);
        preferenceManager = new PreferenceManager(getApplicationContext());
        backImage = findViewById(R.id.imageBack);
        recyclerView = findViewById(R.id.usersRecyclerView);
        setListener();
        getUser();

    }

    public void setListener(){
        backImage.setOnClickListener(v -> onBackPressed());
    }

    public void getUser(){
        loading(true);
        FirebaseFirestore database = FirebaseFirestore.getInstance();
        database.collection("users")
                .get()
                .addOnCompleteListener(task -> {
                    loading(false);
                    String currentUserID = preferenceManager.getString(Constants.KEY_USER_ID);
                    if(task.isSuccessful() && task.getResult() !=null) {
                        List<CUser> users = new ArrayList<>();
                        for (QueryDocumentSnapshot queryDocumentSnapshot : task.getResult()) {
                            if (currentUserID.equals(queryDocumentSnapshot.getId())) {
                                continue;
                            }
                            CUser user = new CUser();
                            user.name = queryDocumentSnapshot.getString("name");
                            user.phone = queryDocumentSnapshot.getString("phone");
                            user.email = queryDocumentSnapshot.getString("email");
                            user.token = queryDocumentSnapshot.getString("fcmToken");
                            user.id = queryDocumentSnapshot.getId();
                            users.add(user);
                        }
                        if (users.size() > 0) {
                            UserAdapter userAdapter = new UserAdapter(users,this);
                            recyclerView.setAdapter(userAdapter);
                            recyclerView.setVisibility(View.VISIBLE);
                        } else {
                            showErrorMessage();
                        }
                    }else{
                        showErrorMessage();
                    }
                });
    }


    public void showErrorMessage(){
        errorMessage.setText(String.format("%s","No user available"));
        errorMessage.setVisibility(View.VISIBLE);
    }

    public void loading(Boolean isLoading){
        if(isLoading){
            progressBar.setVisibility(View.VISIBLE);
        }else{
            progressBar.setVisibility(View.INVISIBLE);
        }
    }

    @Override
    public void onUserClicked(CUser user) {
        Intent intent = new Intent(getApplicationContext(),chatScreenActivity.class);
        intent.putExtra("user",user);
        startActivity(intent);
        finish();
    }
}