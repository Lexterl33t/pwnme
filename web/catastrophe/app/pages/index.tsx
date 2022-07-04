import getRawBody from 'raw-body'
import { Messages } from 'controllers';
import FormSchema from 'components/forms/FormSchema';
import { PrismaClient } from "@prisma/client"
import MessagesComponent from 'components/messages/MessagesComponent';

export default function Index({ messages }) {
    return (
        <>
            <MessagesComponent messages={messages}/>
            <FormSchema />
        </>
    )
}

export async function getServerSideProps({ req }) {
    const prisma  = new PrismaClient()
    const message = new Messages(prisma)

    if (req.method === 'POST') {
        const body   = await getRawBody(req)
        const buf    = Buffer.from(JSON.stringify(body))
        const parsed = JSON.parse(buf.toString())

        let obj = ''
        for (let c in parsed.data)
            obj += String.fromCharCode(parsed.data[c].toString())

        const str  = JSON.parse(JSON.stringify(obj))
        const json = JSON.parse(str)

        await message.uploadMessage(json.message)
        await message.deleteInstance()
    }

    const allMessages = await message.getAllMessages()
    await message.deleteInstance()

    return {
        props: {
            messages: allMessages
        }
    }
}