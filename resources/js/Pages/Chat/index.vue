<template>
    <div class="max-w-screen-md mx-auto">
        <form @submit.prevent="send">
            <div>
                <InputLabel for="message" value="Message" class="mb-1" />

                <TextInput
                    id="message"
                    type="message"
                    class="mb-4 block w-full"
                    v-model="form.body"
                    required
                    autofocus
                />
            </div>

            <PrimaryButton type="submit"> Send </PrimaryButton>
        </form>
        <div v-if="messages.length > 0">
            <Message
                v-for="message in messages"
                :message="message"
                :key="message.id"
            />
        </div>
    </div>
</template>

<script lang="ts" setup>
import Message from "@/Components/Chat/Message.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Message as MessageType } from "@/message.type";
import axios from "axios";
import { reactive } from "vue";

const form = reactive({
    body: "",
});

interface MessagesProps {
    messages: Array<MessageType>;
}

const props = defineProps<MessagesProps>();

const send = () => {
    axios.post("chat", form).then((res) => props.messages.unshift(res.data));
    form.body = "";
};

window.Echo.channel("chat").listen(".message.store", (res) => {
    console.log(res.message);

    props.messages.unshift(res.message);
});
</script>
