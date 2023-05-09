import Echo from "laravel-echo";
import Pusher from "pusher-js";

/**
 * Object for websockets initialization, channels subscription wrapper
 */
window.Channels = {
    initWebsocket: function() {
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: "pusher",
            key: process.env.MIX_PUSHER_APP_KEY,
            wsHost: window.location.host,
            wsPort: process.env.MIX_PUSHER_PORT ?? 80,
            wssPort: process.env.MIX_PUSHER_PORT ?? 443,
            forceTLS: (process.env.MIX_PUSHER_SCHEME ?? "https") === "https",
            enabledTransports: ["ws", "wss"],
            cluster: process.env.MIX_PUSHER_APP_CLUSTER,
            enableLogging: true,
            disableStats: true,
        });
    },
    subscribe: function(action, callback) {
        if (user_profile.logged_in && ['production', 'staging'].includes(conf.app.env)) {
            window.Echo.private(`profile.${conf.channels.prefix}.${conf.channels.second_prefix}`).listen(`.${action}`, callback);
        }
    },
    unsubscribe: function(action) {
        if (user_profile.logged_in && ['production', 'staging'].includes(conf.app.env)) {
            window.Echo.connector.pusher.channels.channels[`private-profile.${conf.channels.prefix}.${conf.channels.second_prefix}`].unbind(action);
        }
    }
};

if (user_profile.logged_in && ['production', 'staging'].includes(conf.app.env)) {
    Channels.initWebsocket();

    Channels.subscribe('activity.created', (activity) => {
        RightSidebar.addActivity(activity);

        if (activity.author_profile_id != user_profile.id) {
            Notif.info(`${activity.author} ${activity.text}`, 'Activity');
        }
    });
}