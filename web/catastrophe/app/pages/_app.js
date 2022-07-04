import Navbar from 'components/navbar/Navbar';
import 'styles/globals.css';

export default function App({ Component, pageProps }) {
    return (
        <>
            <Navbar />
            <main className="h-screen w-screen bg-slate-100">
                <Component {...pageProps} />
            </main>
        </>
    )
}