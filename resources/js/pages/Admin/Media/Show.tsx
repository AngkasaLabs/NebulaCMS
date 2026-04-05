import { Head, router } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { format } from 'date-fns';
import { id } from 'date-fns/locale';
import { Image as ImageIcon, File, FileText, Film, Music } from 'lucide-react';

interface Media {
    id: number;
    name: string;
    url: string;
    mime_type: string | null;
    size: string;
    dimensions?: {
        width: number;
        height: number;
    };
    created_at: string;
    user: {
        name: string;
    } | null;
}

interface Props {
    media: Media;
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Media',
        href: route('admin.media.index'),
    },
    {
        title: 'View'
    },
];

export default function Show({ media }: Props) {
    const getFileIcon = (mimeType: string | null) => {
        if (!mimeType) return <File className="w-6 h-6" />;
        if (mimeType.startsWith('image/')) return <ImageIcon className="w-6 h-6" />;
        if (mimeType.startsWith('video/')) return <Film className="w-6 h-6" />;
        if (mimeType.startsWith('audio/')) return <Music className="w-6 h-6" />;
        if (mimeType.startsWith('application/pdf')) return <FileText className="w-6 h-6" />;
        return <File className="w-6 h-6" />;
    };

    const getFileType = (mimeType: string | null) => {
        if (!mimeType) return 'Unknown';
        const [type, subtype] = mimeType.split('/');
        return `${type.charAt(0).toUpperCase() + type.slice(1)} (${subtype})`;
    };

    const handleDelete = () => {
        if (confirm('you sure you want to delete this file?')) {
            router.delete(route('admin.media.destroy', { id: media.id }));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Media: ${media.name}`} />

            <div className="p-4">
                <div className="flex justify-between items-center mb-4">
                    <h1 className="text-2xl font-bold">{media.name}</h1>
                    <div className="flex gap-2">
                        <Button
                            variant="outline"
                            onClick={() => window.open(route('admin.media.download', { media: media.id }))}
                        >
                            Download
                        </Button>
                        <Button variant="destructive" onClick={handleDelete}>
                            Delete
                        </Button>
                    </div>
                </div>

                <div className="grid gap-4 md:grid-cols-2">
                    <Card>
                        <CardHeader>
                            <CardTitle>Preview</CardTitle>
                        </CardHeader>
                        <CardContent>
                            {media.mime_type?.startsWith('image/') ? (
                                <img
                                    src={media.url}
                                    alt={media.name}
                                    className="w-full rounded-lg"
                                />
                            ) : (
                                <div className="w-full aspect-square flex items-center justify-center bg-gray-100 rounded-lg">
                                    {getFileIcon(media.mime_type)}
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>File Information</CardTitle>
                        </CardHeader>
                        <CardContent className="grid gap-4">
                            <div>
                                <h3 className="font-medium">Name</h3>
                                <p>{media.name}</p>
                            </div>
                            <div>
                                <h3 className="font-medium">Type</h3>
                                <p>{getFileType(media.mime_type)}</p>
                            </div>
                            <div>
                                <h3 className="font-medium">Size</h3>
                                <p>{media.size || '0 B'}</p>
                            </div>
                            {media.dimensions && (
                                <div>
                                    <h3 className="font-medium">Dimensions</h3>
                                    <p>{media.dimensions.width} × {media.dimensions.height} pixels</p>
                                </div>
                            )}
                            <div>
                                <h3 className="font-medium">Uploaded By</h3>
                                <p>{media.user?.name || 'Unknown'}</p>
                            </div>
                            <div>
                                <h3 className="font-medium">Upload Date</h3>
                                <p>{format(new Date(media.created_at), 'dd MMMM yyyy HH:mm', { locale: id })}</p>
                            </div>
                            {media.url && (
                                <div>
                                    <h3 className="font-medium">URL</h3>
                                    <p className="break-all">{media.url}</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}
