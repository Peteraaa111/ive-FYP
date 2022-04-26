package android.exercise.travelhk.firebase.chat;

import android.exercise.travelhk.databinding.ContainerRecentConversionBinding;
import android.view.LayoutInflater;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.text.SimpleDateFormat;
import java.util.List;

public class RecentConversationAdapter extends RecyclerView.Adapter<RecentConversationAdapter.ConversionViewHolder>{

    private final List<ChatMessage> chatMessages;
    private final ConversionListener conversionListener;

    public RecentConversationAdapter(List<ChatMessage> chatMessages, ConversionListener conversionListener) {
        this.chatMessages = chatMessages;
        this.conversionListener = conversionListener;
    }

    @NonNull
    @Override
    public ConversionViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        return new ConversionViewHolder(
                ContainerRecentConversionBinding.inflate(
                        LayoutInflater.from(parent.getContext()),
                        parent,false
                )
        );
    }

    @Override
    public void onBindViewHolder(@NonNull ConversionViewHolder holder, int position) {
        holder.setData(chatMessages.get(position));
    }

    @Override
    public int getItemCount() {
        return chatMessages.size();
    }

    class ConversionViewHolder extends RecyclerView.ViewHolder{
        ContainerRecentConversionBinding binding;

        ConversionViewHolder(ContainerRecentConversionBinding containerRecentConversionBinding){
            super(containerRecentConversionBinding.getRoot());
            binding = containerRecentConversionBinding;
        }

        void setData(ChatMessage chatMessage){
            binding.UsertextName.setText(chatMessage.conversionName);
            binding.textRecentMessage.setText(chatMessage.message);
            SimpleDateFormat dateFormat = new SimpleDateFormat("hh:mm a");
            binding.msgTime.setText(dateFormat.format(chatMessage.dateObject));
            binding.getRoot().setOnClickListener(v -> {
                CUser user = new CUser();
                user.id = chatMessage.conversionId;
                user.name = chatMessage.conversionName;
                conversionListener.onConversionClicked(user);
            });
        }
    }
}
