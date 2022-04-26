package android.exercise.travelhk;

import com.google.firebase.database.DataSnapshot;

public class MyLocation {
    private double latitude;
    private double logitude;
    private String email;

    public MyLocation(double latitude,double logitude,String email){
        this.latitude = latitude;
        this.logitude = logitude;
        this.email = email;
    }
    public MyLocation(){

    }

    public double getLatitude() {
        return latitude;
    }

    public void setLatitude(double latitude) {
        this.latitude = latitude;
    }

    public double getLogitude() {
        return logitude;
    }

    public void setLogitude(double logitude) {
        this.logitude = logitude;
    }

    public void setLocation(DataSnapshot snapshot){
       if(this.isEmailOnly(snapshot)){
           this.email = snapshot.child("email").getValue().toString();
       }else{
           this.latitude = Double.parseDouble(snapshot.child("lat").getValue().toString());
           this.logitude = Double.parseDouble(snapshot.child("lng").getValue().toString());
           this.email = snapshot.child("email").getValue().toString();
       }
    }

    private boolean isEmailOnly(DataSnapshot snapshot){
        if(snapshot.child("lat").getValue() != null && snapshot.child("lng").getValue() != null){
            return false;
        }
        return true;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }
}
