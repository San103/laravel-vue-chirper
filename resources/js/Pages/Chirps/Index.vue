<template>
    <Head title="Chirps" />
 
    <AuthenticatedLayout>
        <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
            
                <div class="w-full p-4 mb-10 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-10 dark:bg-white dark:border-gray-300">
                    <form class="space-y-3" action="#">
                        <h5 class="text-xl font-medium text-gray-600 ">Test</h5>
                        <div class="flex" :class="$page.props.auth.user.id === chirp.user.id ? 'justify-end' : 'justify-start'" v-for="chirp in chirps" :key="chirp.id">
                            <div class="flex flex-col">
                                <div class="flex" :class="$page.props.auth.user.id === chirp.user.id ? 'justify-end' : 'justify-start'">
                                    <span class="text-sm px-2 py-1.5 text-gray-600">{{chirp.user.name}}</span>
                                </div>
                                <div class="flex items-center" >
                                    
                                    <!-- <div class="flex flex-row-reverse items-center" :class="$page.props.auth.user.id === chirp.user.id ? 'flex' : ''" > -->
                                        <div class="flex place-items-center" :class="$page.props.auth.user.id !== chirp.user.id ? 'flex-row-reverse' : ''">
                                            <small class="text-xs text-gray-500 px-3">{{ timeMessage(chirp.created_at) }}</small>
                                            <span class="p-2 py-1.5 px-4 rounded-full text-sm font-thin" :class="$page.props.auth.user.id === chirp.user.id ? 'dark:text-white bg-blue-600' : ' text-gray-900 border-2 border-gray-400'">{{chirp.message}}</span>
                                        </div>
                                    <!-- </div> -->
                                    
                                    <Dropdown v-if="chirp.user.id === $page.props.auth.user.id">
                                        <template #trigger>
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical text-gray-400" viewBox="0 0 16 16">
                                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                </svg>
                                            </button>
                                        </template>
                                        <template #content>
                                            <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                                                Edit
                                            </button>
                                            <DropdownLink as="button" :href="route('chirps.destroy', chirp.id)" method="delete">
                                                Delete
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                    <!-- {{ chirp.id }} -->
                                    <form v-if="editing" @submit.prevent="form.put(route('chirps.update', chirp.id), { onSuccess: () => editing = false })">
                                        <input v-model="chirp.message" class="p-2 px-4 rounded-full text-sm font-thin" :class="$page.props.auth.user.id === chirp.user.id ? 'dark:text-white bg-blue-600' : ' text-gray-900 border-2 border-gray-400'">

                                        <!-- <textarea v-model="form.message" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea> -->
                                        <InputError :message="form.errors.message" class="mt-2" />
                                        <!-- <div class="space-x-2">
                                            <PrimaryButton class="mt-4">Save</PrimaryButton>
                                            <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                                        </div> -->
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div >
                            <span v-show="typing" class="py-1.5 px-4 rounded-full text-sm font-thin">{{user}} is typing ...</span>
                        </div>
                        <!-- <div class="flex justify-start">
                            <span class="p-3 px-4 rounded-full text-sm font-thin text-gray-900 border-2 border-gray-400 ">Your message here..</span>
                        </div> -->
                     
                        <!-- <div class="text-sm font-medium flex justify-center items-center space-x-6 pt-10">
                            <input type="text" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm pl-4 p-3 rounded-full focus:none focus:border-none w-full " placeholder="Write Something....">

                            <PrimaryButton class="rounded-full">Send</PrimaryButton>
                        </div> -->
                    </form>
                </div>

            <form @submit.prevent="submmitForm">
                <textarea
                    v-model="form.message"
                    @input="typeMessage"
                    placeholder="What's on your mind?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>
                <InputError :message="form.errors.message" class="mt-2" />
                <div class="flex justify-end">

                    <PrimaryButton class="mt-4">Send</PrimaryButton>
                </div>
            </form>
  
            <!-- <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Chirp
                    v-for="chirp in chirps"
                    :key="chirp.id"
                    :chirp="chirp"
                />
            </div> -->
        </div>
    </AuthenticatedLayout>
</template>

<script>

import { useForm, Head } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { SmileOutlined } from '@ant-design/icons-vue';
import { notification } from 'ant-design-vue';
import { h } from 'vue';

dayjs.extend(relativeTime);

export default{
    data() {
        return {
            form: useForm({
                 message: '',
            }),
            typing: false,
            user: '',
            data:{
                name:'',
                message:''
            },
            editing:false,
        }
    },
    props:{
        chirps: Array
    },
    methods:{
        submmitForm(){
            // console.log(window.Echo.socketId());
            this.form.post(route('chirps.store'), {onSuccess: () => { this.form.reset()} })
        },
        timeMessage(createdAt){
            return dayjs(createdAt).fromNow();
        },
        typeMessage(){

            const userAuth = this.$page.props.auth.user.name;

            let channel = Echo.private('chatType.1');

            setTimeout(function() {
                channel.whisper('typing', {
                user: userAuth,
                typing: true
                });
            }, 300);
        }

    },  
    
    mounted() {

        // console.log(this.chirps);
        const appendArray = (data)=> {
            this.chirps.push({'id':data.message_id, 'message': data.message, 'user': { 'name' : data.user}});
        };
        const removeMessage = (data) => {
            
            // this.chirps.filter((item) => item.id !== data.user);
            // const indexToRemove = data.findIndex(item => item.id === idToRemove);
            const removeMessage = this.chirps.findIndex(item => item.id === data.user);

                if (removeMessage !== -1) {
                // If the index is found (not -1), use splice to remove the object
                    this.chirps.splice(removeMessage, 1);
                }
        };

        if (this.$page.props.auth) {
        
            Echo.join(`chat.${this.$page.props.auth.user.chat_room_id}`)
                .here((users) => {
                    console.log("Here -"+ users);
                })
                .joining((user) => {
                    console.log("Joining -"+ user.name);
                })
                .leaving((user) => {
                    console.log("Leaving -"+ user.name);
                })
               
                .listen('.my-event', function(data) {
                   
                    // console.log(data);
                    appendArray(data);

                    notification.open({
                        message: `Message from ${data.user}` ,
                        description:
                        `${data.user} says '${data.message}'`,
                        icon: () => h(SmileOutlined, { style: 'color: #108ee9' }),
                    });
                })
                
           Echo.private(`delete.${this.$page.props.auth.user.chat_room_id}`)
                .listen('.delete-event', function (data) {
                    // console.log(data);
                    removeMessage(data);
                })
               
           Echo.private('chatType.1')
                    .listenForWhisper('typing', (e) => { Ambot
                        this.typing = e.typing,
                        this.user = e.user,

                        setTimeout(() => {
                            this.typing = false;
                            console.log('object');
                        }, 900);
                })
                
        }
    },
}
</script>