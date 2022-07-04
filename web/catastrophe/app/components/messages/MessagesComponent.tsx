import Message from 'components/messages/message/Message'

export default function MessagesComponent({ messages }) {
    return (
        <>
            <div className="flex-1 p-1 flex-row">
                {
                    messages.map((message, i: number) => {
                        return (
                                <>
                                    <div className="my-1">
                                        <Message key={i} message={message.msg_content} author={message.users_tbl.usr_username}></Message>
                                    </div>
                                </>
                            )
                    })
                }
            </div>
        </>
    )
}