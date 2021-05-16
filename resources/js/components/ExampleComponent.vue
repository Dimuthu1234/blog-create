<template>
    <div class="table-responsive">

        <form @submit.prevent="searchRecord">
            <div class="row">
                <div class="col-md-10">
                    <input class="form-control" v-model="search" placeholder="Search..." name="search" id="search">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary search-btn" style="width: 100%">Search</button>
                </div>
            </div>
        </form>

        <div v-for="record in postRecords" v-bind:key="record.post.id">
            <div class="card" style="margin-top: 50px">
                <div class="card-header">{{ record.post.title }}</div>
                <div class="card-body">
                    <p>{{ record.post.description }}</p>
                </div>
                <div class="row">
                    <div class="col-md-10 offset-1 comment">
                        <div v-for="comment in record.comments" v-bind:key="comment.id">
                            <p>{{ comment.comment }}</p>
                        </div>
                        <form @submit.prevent="addComment(record.post.id)">
                            <input type="hidden" name="post_id" v-model="record.post.id">
                            <textarea class="form-control" name="comment" style="margin-bottom: 20px"
                                      placeholder="Comments here...." v-if="record.post.id"
                                      v-model="write.comment"></textarea>
                            <button type="submit" class="float-right btn btn-sm btn-primary"
                                    style="margin-bottom: 20px">Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                postRecords: [],
                search: '',
                write: {
                    comment: ''
                },
                pagination: {},
            }
        },

        created() {
            this.fetchAllPosts();
        },

        methods: {
            searchRecord() {
                fetch('/post/search', {
                    method: 'post',
                    body: JSON.stringify({'search': this.search}),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data)
                        this.postRecords = data;
                    })
                    .catch(err => console.log(err));
            },
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
                        console.log(data)
                        this.fetchAllPosts();
                    })
                    .catch(err => console.log(err));
            },
            fetchAllPosts() {
                fetch('/post/get-all-post', {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        let vm = this;
                        this.postRecords = data;
                    })
                    .catch(err => console.log(err));
            }
        },
    }
</script>
