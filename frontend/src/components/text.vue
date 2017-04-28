<template>
  <div class="easy-content">
      <p>
        Easy PHP
      </p>
      <p>
        A lightweight PHP framework for studying
      </p>
  </div>
</template>

<script>
  	module.exports = {
  		data: function () {
  			return {

  			}
  		},
	    mounted: function () {
				this.$nextTick(function () {

				})
	    },
	    methods: {

	    }
  	}
</script>

<style>
  .easy-content{
    text-align: center;
    padding-top: 200px;
  }
  .easy-content p:first-child{
    color: #000;
    font-size: 25px;
  }
  .easy-content p:last-child{
    padding-top: 20px;
    color: #bbb;
  }
</style>
