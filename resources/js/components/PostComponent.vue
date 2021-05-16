<template>
    <div class="card" style="margin-top: 50px">
        <div class="card-header">{{ postFetch['title'] }}</div>
        <div class="card-body">
            <p>{{ postFetch['description'] }}</p>
        </div>
        <div class="row">
            <div class="col-md-10 offset-1 comment">
                <div v-for="comment in postFetch['comments']" v-bind:key="comment.id">
                    <p>{{ comment.comment }}</p>
                </div>
                <form @submit.prevent="addComment(postFetch['id'])">
                    <input type="hidden" name="post_id" v-model="postFetch['id']">
                    <textarea class="form-control" name="comment" style="margin-bottom: 20px"
                              placeholder="Comments here...." v-if="postFetch['id']"
                              v-model="write.comment"></textarea>
                    <button type="submit" class="float-right btn btn-sm btn-primary"
                            style="margin-bottom: 20px">Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['post'],
        data() {
            return {
                write: {
                    comment: ''
                },
                postFetch: this.post
            }
        },
        methods: {
            addComment(post_id) {
                fetch('/comment', {
                    method: 'post',
                    body: JSON.stringify({'comment': this.write.comment, 'post_id': post_id}),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        $('input[name="post_id"]').val('')
                        this.write.comment = '';
                        this.fetchPostByID(this.postFetch['id']);
                    })
                    .catch(err => console.log(err));
            },
            fetchPostByID(postID) {
                fetch('/post/get-post-by-id', {
                    method: 'post',
                    body: JSON.stringify({'post_id': postID}),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        this.postFetch = data;
                    })
                    .catch(err => console.log(err));
            }
        }
    }
</script>
