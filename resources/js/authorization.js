let user = window.App.user;

    module.exports = {
        updateReply(reply) {
            return reply.user.id === user.id;
        },
        updateThread(thread) {
            return thread.user.id === user.id;
        }
    };
