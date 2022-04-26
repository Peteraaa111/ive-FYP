package android.exercise.travelhk;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.util.ArrayList;
import java.util.List;

public class RecyclerAdapter extends RecyclerView.Adapter<RecyclerAdapter.MyViewHolder> {
     private Context mContext;
     private List<DriverOrder> objects = new ArrayList<>();

     public RecyclerAdapter(Context context, List<DriverOrder> objects){
         this.objects = objects;
         this.mContext = context;
     }

     public class MyViewHolder extends RecyclerView.ViewHolder{
         private TextView startAddress, endAddress,startDate,startTime,peopleNumber,bookingId;
         private LinearLayout mContainer;
         public MyViewHolder(View view){
             super(view);
             startAddress = view.findViewById(R.id.startAddress);
             endAddress = view.findViewById(R.id.endAddress);
             startDate = view.findViewById(R.id.startDate);
             startTime = view.findViewById(R.id.startTime);
             peopleNumber = view.findViewById(R.id.peopleNumber);
             mContainer = view.findViewById(R.id.order_container);
             bookingId = view.findViewById(R.id.bookingID);
         }
     }

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
         View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.recycler_list_layout,parent,false);
         return new MyViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull MyViewHolder holder, int position) {
        DriverOrder object = objects.get(position);
        holder.startAddress.setText("起點: "+object.getStartAddress());
        holder.endAddress.setText("終點: "+object.getEndAddress());
        holder.startDate.setText("日期: "+object.getStartDate());
        holder.startTime.setText("時間: "+object.getStartTime());
        holder.peopleNumber.setText("人數: "+object.getPeopleNumber());
        holder.bookingId.setText("編號: "+object.getBookingId());
        holder.mContainer.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(mContext,DetailedOrdersActivity.class);
                intent.putExtra("startAddress",object.getStartAddress());
                intent.putExtra("endAddress",object.getEndAddress());
                intent.putExtra("startDate",object.getStartDate());
                intent.putExtra("startTime",object.getStartTime());
                intent.putExtra("peopleNumber",object.getPeopleNumber());
                intent.putExtra("bookingId",object.getBookingId());
                intent.putExtra("email",object.getEmail());
                intent.putExtra("accountid",object.getAccountid());
                mContext.startActivity(intent);
            }
        });

    }

    @Override
    public int getItemCount() {
        return objects.size();
    }
}
