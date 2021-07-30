<template>
    <div>
        <h2 class="verygood-font text-2xl">{{ event.title }} Registrants</h2>

        <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Confirmation Number
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        T-Shirt Order?
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Details</span>
                    </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="registration in registrations">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex">
                        <div>
                            <div class="text-sm font-medium text-gray-900">
                            {{ registration.registrant.name }}
                            </div>
                            <div class="text-sm text-gray-500">
                            {{ registration.registrant.email }}
                            </div>
                        </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ registration.confirmation_number }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span v-show="registration.checked_in_at === null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Not checked in
                        </span>
                        <span v-show="registration.checked_in_at !== null" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Checked in!
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span v-if="registration.hasOwnProperty('shirt_order') === false" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            No shirt order
                        </span>
                        <span v-else-if="registration.hasOwnProperty('shirt_order') === true" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ getSizeLabel(registration.shirt_order.size) }} shirt
                        </span>
                    </td>
                    <td class="hidden px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Details</a>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
        </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "RegistrantsList",
        methods: {
            getEventRegistrants(){
                axios
                    .get('/manager/api/event/' + this.event.id + '/registrants')
                    .then(response => {
                        this.registrations = response.data;
                    });
            },
            getSizeLabel(size){
                if(size == 's') {
                    return "Small";
                } else if (size == 'm' || size == 'xm'){
                    return "Medium"
                } else if (size == 'lg'){
                    return "Large";
                }

                return size;
            }
        },
        data() {
            return {
                event: [],
                registrations: [],
            }
        },
        created() {
            this.$root.$on('event-selected', event => {
                this.event = event;
                this.getEventRegistrants();
            });
        }
    }
</script>

<style scoped>

</style>