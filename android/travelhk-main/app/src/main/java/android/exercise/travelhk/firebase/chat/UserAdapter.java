package android.exercise.travelhk.firebase.chat;

import android.exercise.travelhk.databinding.ContainerUserBinding;
import android.text.Layout;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;


import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import java.util.List;

public class UserAdapter extends RecyclerView.Adapter<UserAdapter.UserViewHolder>{
    private final List<CUser> users;
    private final UserListener userListener;
    public UserAdapter(List<CUser>users, UserListener userListener){
        this.users = users;
        this.userListener = userListener;
    }

    @NonNull
    @Override
    public UserViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        ContainerUserBinding containerUserBinding = ContainerUserBinding.inflate(
                LayoutInflater.from(parent.getContext()),
                parent,false
        );
        return new UserViewHolder(containerUserBinding);
    }

    @Override
    public void onBindViewHolder(@NonNull UserViewHolder holder, int position) {
        holder.setUserData(users.get(position));
    }

    @Override
    public int getItemCount() {
        return users.size();
    }

    class UserViewHolder extends RecyclerView.ViewHolder{
        ContainerUserBinding binding;


        public UserViewHolder(ContainerUserBinding containerUserBinding) {
            super(containerUserBinding.getRoot());
            binding = containerUserBinding;
        }

        void setUserData(CUser user){
            binding.UsertextName.setText(user.name);
            binding.phone.setText(user.phone);
            //binding.msgTime.setText(user.lastMessageTime);
            binding.getRoot().setOnClickListener(v -> userListener.onUserClicked(user));
        }
    }
}
