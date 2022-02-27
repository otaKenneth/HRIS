<template>
    <v-menu top offset-y>
        <template v-slot:activator="{ on }">
            <a href="#" dark v-on="on">
                <i class="fa fa-bell" aria-hidden="true"></i>
                <span v-if="notifications.length > 0" class="badge badge-pill badge-warning notification">{{notifications.length}}</span>
            </a>
        </template>
        <v-list width="20vw" style="max-height: 40vh; overflow: auto">
            <v-list-item v-for="(item, index) in notifications" :key="index" three-line class="cursor-pointer hover:bg-gray-200" @click="setRead(item)">
                <v-list-item-content>
                    <v-list-item-title>{{ item.data.type }}</v-list-item-title>
                    <v-list-item-subtitle>{{ item.data.text }}</v-list-item-subtitle>
                    <v-list-item-subtitle>{{ item.data.by }}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-list-item v-if="notifications.length == 0">
                <v-list-item-content>
                    <v-list-item-title>No New Notifications</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-menu>
</template>
<script>
export default {
    props: ['user', 'unreads'],
    data () {
        return {
            notifications: this.unreads,
        }
    },
    mounted () {
        Echo.private(`App.User.${this.user}`).notification( (notification) => {
            if (!notification.title) {
                this.getNotifs();
            }else{
                this.notifications.push(notification);
            }
        });
    },
    methods: {
        getNotifs() {
            axios.get(`/Notifications`).then(response => {
                this.notifications = response.data;
            })
        },
        setRead (item) {
            axios.patch(`/Notifications/${item.id}`).then(response => {
                location.href = item.data.link;
            });
        }
    }
}
</script>