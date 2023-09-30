<template>

    <table class="table">
        <thead>
            <tr>
                <th>
                    <span>#</span>
                </th>
                <th>
                    <span>User ID</span>
                </th>
                <th>
                    <span>Transaction Type</span>
                </th>
                <th>
                    <span>Amount</span>
                </th>
                <th>
                    <span>Fee</span>
                </th>
                <th>
                    <span>Date</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(transaction,key) in Transactions">
                <th scope="row">{{ ++key }}</th>
                <td>
                    {{ transaction.user_id }}
                </td>
                <td>
                    {{ transaction.transaction_type }}
                </td>
                <td>
                    {{ transaction.amount }}
                </td>
                <td>
                    {{ transaction.fee }}
                </td>
                <td>
                    {{ transaction.date }}
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    data() {
        return {
            Transactions: []
        }
    },
    mounted() {
        this.fetchTransactions()
        console.log(this.Transactions);
    },
    methods: {
        fetchTransactions() {
            axios.get('/getTransactionList')
                .then(response => this.Transactions = response.data)
                .catch(error => console.log(error))
        }
    }
}
</script>
