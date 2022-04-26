package android.exercise.travelhk;

import java.text.SimpleDateFormat;
import java.util.Calendar;
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

import java.util.ArrayList;
import java.util.List;

public class driverScheduleRecyclerAdapter extends RecyclerView.Adapter<driverScheduleRecyclerAdapter.MyViewHolder> {
     String date;
     private Context mContext;
     private List<DriverCurrentOrder> objects = new ArrayList<>();

     public driverScheduleRecyclerAdapter(Context context, List<DriverCurrentOrder> objects){
         this.objects = objects;
         this.mContext = context;
     }

     public class MyViewHolder extends RecyclerView.ViewHolder{
         private TextView startAddress, endAddress,startDate,startTime,peopleNumber,bookingId,userName,userPhone;
         private LinearLayout mContainer;
         Calendar calendar;
         String date;
         SimpleDateFormat simpleDateFormat;
         public MyViewHolder(View view){
             super(view);
             startAddress = view.findViewById(R.id.CurrentstartAddress);
             endAddress = view.findViewById(R.id.CurrentendAddress);
             startDate = view.findViewById(R.id.CurrentstartDate);
             startTime = view.findViewById(R.id.CurrentstartTime);
             peopleNumber = view.findViewById(R.id.CurrentpeopleNumber);
             mContainer = view.findViewById(R.id.order_container);
             bookingId = view.findViewById(R.id.CurrentbookingID);
             userName = view.findViewById(R.id.CurrentUserName);
             userPhone = view.findViewById(R.id.CurrentUserPhone);
             simpleDateFormat = new SimpleDateFormat("yyyy-MM-dd");
             date=simpleDateFormat.format(Calendar.getInstance().getTime());
         }
     }

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
         View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.driver_list_schedule_layout,parent,false);
         return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        DriverCurrentOrder object = objects.get(position);
        //holder.startAddress.setText("起點: "+object.getStartAddress());
        holder.startAddress.setText("起點: "+object.getStartAddress());
        holder.endAddress.setText("終點: "+object.getEndAddress());
        holder.startDate.setText("日期: "+object.getStartDate());
        holder.startTime.setText("時間: "+object.getStartTime());
        holder.peopleNumber.setText("人數: "+object.getPeopleNumber());
        holder.bookingId.setText("編號: "+object.getBookingId());
        holder.userName.setText("客戶名稱: "+object.getUserName());
        holder.userPhone.setText("客戶電話: "+object.getUserPhone());
        holder.mContainer.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(object.getStartDate().equals(holder.date)){
                    Intent intent = new Intent(mContext,MapActivity.class);
                    intent.putExtra("startAddress",object.getStartAddress());
                    intent.putExtra("endAddress",object.getEndAddress());
                    intent.putExtra("startDate",object.getStartDate());
                    intent.putExtra("startTime",object.getStartTime());
                    intent.putExtra("peopleNumber",object.getPeopleNumber());
                    intent.putExtra("bookingId",object.getBookingId());
                    intent.putExtra("email",object.getEmail());
                    intent.putExtra("accountid",object.getAccountid());
                    intent.putExtra("userName",object.getUserName());
                    intent.putExtra("userPhone",object.getUserPhone());
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
