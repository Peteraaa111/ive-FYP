package android.exercise.travelhk.firebase.chat;

import android.content.Context;
import android.exercise.travelhk.R;
import android.exercise.travelhk.databinding.ContainerReceivedMessageBinding;
import android.exercise.travelhk.databinding.ContainerSentMessageBinding;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;

import java.util.List;

public class ChatAdapter extends  RecyclerView.Adapter<RecyclerView.ViewHolder>{

    private final List<ChatMessage> chatMessages;
    private final String senderId;
    private Context mContext;
    public static final int VIEW_TYPE_SENT = 1;
    public static final int VIEW_TYPE_RECEIVED = 2;


    public ChatAdapter(List<ChatMessage> chatMessages, String senderId) {
        this.chatMessages = chatMessages;
        this.senderId = senderId;
    }

    @NonNull
    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        if(viewType == VIEW_TYPE_SENT){
            return new SentMessageViewHolder(
                    ContainerSentMessageBinding.inflate(
                            LayoutInflater.from(parent.getContext()),
                            parent,false
                    )
            );
        }else{
            return new ReceivedMessageViewHolder(
                    ContainerReceivedMessageBinding.inflate(
                            LayoutInflater.from(parent.getContext()),
                            parent,false
                    )
            );
        }
    }

    @Override
    public void onBindViewHolder(@NonNull RecyclerView.ViewHolder holder, int position) {
        if(getItemViewType(position)==VIEW_TYPE_SENT){
            ((SentMessageViewHolder)holder).setData(chatMessages.get(position));
        }else{
            ((ReceivedMessageViewHolder)holder).setData(chatMessages.get(position));
        }
    }

    @Override
    public int getItemCount() {
        return chatMessages.size();
    }

    @Override
    public int getItemViewType(int position) {
        if(chatMessages.get(position).senderId.equals(senderId)){
            return VIEW_TYPE_SENT;
        }else{
            return VIEW_TYPE_RECEIVED;
        }
    }

    static class SentMessageViewHolder extends RecyclerView.ViewHolder{
        private final ContainerSentMessageBinding binding;

        SentMessageViewHolder(ContainerSentMessageBinding containerSentMessageBinding){
            super(containerSentMessageBinding.getRoot());
            binding = containerSentMessageBinding;
        }

        void setData(ChatMessage chatMessage){
            if(chatMessage.message.equals("photo")){
                binding.SendTextMessage.setVisibility(View.GONE);
                binding.imageSent.setVisibility(View.VISIBLE);
                binding.SendTextDateTime.setText(chatMessage.dateTime);
                Glide.with(binding.getRoot())
                        .load(chatMessage.UrlImage)
                        .placeholder(R.drawable.placeholder)
                        .into(binding.imageSent);
            }else{
                binding.SendTextMessage.setVisibility(View.VISIBLE);
                binding.imageSent.setVisibility(View.GONE);
                binding.SendTextMessage.setText(chatMessage.message);
                binding.SendTextDateTime.setText(chatMessage.dateTime);
            }
//            binding.SendTextMessage.setText(chatMessage.message);
//            binding.SendTextDateTime.setText(chatMessage.dateTime);

        }
    }

    static class ReceivedMessageViewHolder extends RecyclerView.ViewHolder{
        private final ContainerReceivedMessageBinding binding;

        ReceivedMessageViewHolder(ContainerReceivedMessageBinding containerReceivedMessageBinding){
            super(containerReceivedMessageBinding.getRoot());
            binding = containerReceivedMessageBinding;
        }

        void setData(ChatMessage chatMessage){
            if(chatMessage.message.equals("photo")){
                binding.receivedTextMessage.setVisibility(View.GONE);
                binding.imageReceived.setVisibility(View.VISIBLE);
                binding.receivedTextDateTime.setText(chatMessage.dateTime);
                Glide.with(binding.getRoot())
                        .load(chatMessage.UrlImage)
                        .placeholder(R.drawable.placeholder)
                        .into(binding.imageReceived);
            }else {
                binding.receivedTextMessage.setVisibility(View.VISIBLE);
                binding.imageReceived.setVisibility(View.GONE);
                binding.receivedTextMessage.setText(chatMessage.message);
                binding.receivedTextDateTime.setText(chatMessage.dateTime);
            }
        }

    }

}
