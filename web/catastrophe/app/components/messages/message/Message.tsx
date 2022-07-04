import MarkdownView from 'react-showdown'

export default function Message({ message, author }) {
    message = message.replace(/(http)|(\/\/)/, '1337')
    return (
        <>
            <div className="bg-white border-2 px-1 rounded-lg">
                <p className="text-stone-500">
                    {author}
                </p>
                <MarkdownView dangerouslySetInnerHTML markdown={message}/>
            </div>
        </>
    )
}