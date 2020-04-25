<template>
    <div id="app">
         <router-view></router-view>
    </div>
</template>

<script>
export default {
    name:"app",
    data() {
        return {
            loading:false,
            init:null,
            req:axios.create({
                baseUrl:BASE_URL
            })
        }
    },
    methods:{
        init(){
            this.req.get("");
        }
    }
}
</script>