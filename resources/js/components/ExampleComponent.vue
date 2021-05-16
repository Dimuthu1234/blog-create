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

        <div v-for="record in postRecords" v-bind:key="record.id">
            <post-component v-bind:post="record"></post-component>
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
                        console.log(data)
                        this.postRecords = data;
                    })
                    .catch(err => console.log(err));
            }
        },
    }
</script>
