package android.exercise.travelhk;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.MenuItem;

import com.google.android.material.bottomnavigation.BottomNavigationView;

public class Setting extends AppCompatActivity {
    PreferenceManager preferenceManager;
    private int type;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_setting);
        preferenceManager = new PreferenceManager(getApplicationContext());
        type = preferenceManager.getInt("type");
        BottomNavigationView bottomNavigationView =  findViewById(R.id.bottom_nagivation);
        bottomNavigationView.setSelectedItemId(R.id.home);
        bottomNavigationView.setOnNavigationItemSelectedListener(new BottomNavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(MenuItem menuItem) {
                switch (menuItem.getItemId()){
                    case R.id.home:
                        if(type==5) {
                            startActivity(new Intent(getApplicationContext(), DriverHomePage.class));
                            overridePendingTransition(0, 0);
                            return true;
                        }else{
                            startActivity(new Intent(getApplicationContext(), Home.class));
                            overridePendingTransition(0, 0);
                            return true;
                        }
                    case R.id.Setting:
                        startActivity(new Intent(getApplicationContext(), Setting.class));
                        overridePendingTransition(0, 0);
                        return true;
                    case R.id.user:
                        if(type==5) {
                            startActivity(new Intent(getApplicationContext(), Driver.class));
                            overridePendingTransition(0, 0);
                            return true;
                        }else{
                            startActivity(new Intent(getApplicationContext(), User.class));
                            overridePendingTransition(0, 0);
                            return true;
                        }
                }
                return false;
            }
        });
    }
}