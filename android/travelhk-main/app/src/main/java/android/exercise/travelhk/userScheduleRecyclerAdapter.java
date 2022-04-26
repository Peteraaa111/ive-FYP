package android.exercise.travelhk;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

public class userScheduleRecyclerAdapter extends RecyclerView.Adapter<userScheduleRecyclerAdapter.MyViewHolder> {
     private Context mContext;
     private List<UserCurrentOrder> objects = new ArrayList<>();

     public userScheduleRecyclerAdapter(Context context, List<UserCurrentOrder> objects){
         this.objects = objects;
         this.mContext = context;
     }

     public class MyViewHolder extends RecyclerView.ViewHolder{
         private TextView startAddress, endAddress,startDate,startTime,peopleNumber,bookingId,driverName,driverPhone;
         private LinearLayout mContainer;
         Calendar calendar;
         String date;
         SimpleDateFormat simpleDateFormat;
         public MyViewHolder(View view){
             super(view);
             startAddress = view.findViewById(R.id.UCurrentstartAddress);
             endAddress = view.findViewById(R.id.UCurrentendAddress);
             startDate = view.findViewById(R.id.UCurrentstartDate);
             startTime = view.findViewById(R.id.UCurrentstartTime);
             peopleNumber = view.findViewById(R.id.UCurrentpeopleNumber);
             mContainer = view.findViewById(R.id.order_container);
             bookingId = view.findViewById(R.id.UCurrentbookingID);
             driverName = view.findViewById(R.id.UCurrentDriverName);
             driverPhone = view.findViewById(R.id.UCurrentDriverPhone);
             simpleDateFormat = new SimpleDateFormat("yyyy-MM-dd");
             date=simpleDateFormat.format(Calendar.getInstance().getTime());
         }
     }

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
         View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.user_list_schedule_layout,parent,false);
         return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        UserCurrentOrder object = objects.get(position);
        holder.startAddress.setText("起點: "+object.getStartAddress());
        holder.endAddress.setText("終點: "+object.getEndAddress());
        holder.startDate.setText("日期: "+object.getStartDate());
        holder.startTime.setText("時間: "+object.getStartTime());
        holder.peopleNumber.setText("人數: "+object.getPeopleNumber());
        holder.bookingId.setText("編號: "+object.getBookingId());
        holder.driverName.setText("司機名稱: "+object.getDriverName());
        holder.driverPhone.setText("司機電話: "+object.getDrivePhone());
        holder.mContainer.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(mContext,MapActivity.class);
                if(object.getStartDate().equals(holder.date)){
                    intent.putExtra("startAddress",object.getStartAddress());
                    intent.putExtra("endAddress",object.getEndAddress());
                    intent.putExtra("startDate",object.getStartDate());
                    intent.putExtra("startTime",object.getStartTime());
                    intent.putExtra("peopleNumber",object.getPeopleNumber());
                    intent.putExtra("bookingId",object.getBookingId());
                    intent.putExtra("email",object.getEmail());
                    intent.putExtra("accountid",object.getAccountid());
                    intent.putExtra("driverName",object.getDriverName());
                    intent.putExtra("driverPhone",object.getDrivePhone());
                    mContext.startActivity(intent);
                }else{
                    Toast.makeText(mContext, "還沒有達到接載日期", Toast.LENGTH_SHORT).show();
                }
            }
        });

    }

    @Override
    public int getItemCount() {
        return objects.size();
    }
}
