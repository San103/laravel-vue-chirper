<!-- <script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import Chirp from '@/Components/Chirp.vue';
 
defineProps(['chirps']);
const form = useForm({
    message: '',
});
</script> -->
 
<template>
    <Head title="Chirps" />
 
    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="submmitForm">
                <textarea
                    v-model="form.message"
                    placeholder="What's on your mind?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>
                <InputError :message="form.errors.message" class="mt-2" />
                <PrimaryButton class="mt-4">Chirp</PrimaryButton>
            </form>
            <p>{{ test }}</p>
            <!-- <p>{{ chirps }}</p> -->
            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Chirp
                    v-for="chirp in chirps"
                    :key="chirp.id"
                    :chirp="chirp"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import Chirp from '@/Components/Chirp.vue';
import Echo from 'laravel-echo';
import { SmileOutlined } from '@ant-design/icons-vue';
import { notification } from 'ant-design-vue';
import { h } from 'vue';

export default{
    components: {
        AuthenticatedLayout,
        InputError,
        PrimaryButton,
        Chirp,
        Head
    },
    data() {
        return {
            form: useForm({
                 message: '',
            }),
            test: 'Hey',
        }
    },
    props:{
        chirps: Array
    },
    methods:{
        submmitForm(){
            // console.log(window.Echo.socketId());
            this.form.post(route('chirps.store'), {onSuccess: () => { this.form.reset()} })
        }
    },  
    
    mounted() {
        // console.log(this.$page.props.auth);
        if (this.$page.props.auth) {
            let customId=0;
            const echo = new Echo({
                broadcaster: 'pusher',
                key: '519ed7f2d866445efecf',
                cluster: 'ap1',
                forceTLS: true
            });
            // console.log();

            echo.join(`chat.${this.chirps[0].room_id}`)
                .here((users) => {
                    console.log(users);
                })
                .joining((user) => {
                    console.log(user.name);
                })
                .leaving((user) => {
                    console.log(user.name);
                })
                .listen('.my-event', function(data) {

                        notification.open({
                    message: `Message from ${data.user.name}` ,
                    description:
                    `${data.user.name} says '${data.message.message}'`,
                    icon: () => h(SmileOutlined, { style: 'color: #108ee9' }),
                });
                })
                .error((error) => {
                    console.log(error);
                });
        }

       
    //    echo.join('chat.'+ this.chirps[0].room_id)
    //         .here((users) => {
    //             console.log(users);
    //         })
    //         .joining((user) => {
    //             console.log(user.name);
    //         })
    //         .leaving((user) => {
    //             console.log(user.name);
    //         }
    //     //     .here('.my-event', function(data) {

    //     //     // this.chirps.push({'user': {
    //     //     //     'id' : customId++,
    //     //     //     'name' : data.user,
    //     //     //     'message': data.message.message,

    //     //     // }, 
    //     //     //  });
    //     //     // alert(JSON.stringify(data));
    //     //     notification.open({
    //     //         message: `Message from ${data.user}` ,
    //     //         description:
    //     //         `${data.user} says '${data.message.message}'`,
    //     //         icon: () => h(SmileOutlined, { style: 'color: #108ee9' }),
    //     //     });
    //     // }
    //     );
    },
}
</script>